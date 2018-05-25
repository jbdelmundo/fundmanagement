<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Mail;
use Auth;
use App\Http\Requests;
use App\Aysem;
use App\Collection;
use App\Department;
use App\EnrolleeStatistics;
use App\AccountTransactions;
use Illuminate\Support\Facades\DB;

class CollectionController extends Controller
{
    // middleware = isLibrarian

    const UNDERGRAD_WEIGHT = 1;             //undergradate students has  1/3 multiplier
    const GRAD_WEIGHT = 2;                  //graduate students has 2/3 multiplier
    const TOTAL_WEIGHT = 3;
	

    function index(){
        
    	$aysems = Aysem::all();
    	$collections = DB::table('collections')->distinct()->pluck('aysem');
    	$depts_with_percent = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',True)
                                    ->get();

        $depts_with_collection = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',False)
                                    ->get();

    	$current_aysem = Aysem::current();

        //validate that this is the first entry in Collections table
        $is_first_collection = Collection::isFirstCollectionForTheSem($current_aysem);


        
    	return view('collection.index',compact('aysems', 'collections','depts_with_collection', 'depts_with_percent','current_aysem', 'is_first_collection'));
    }

    function show(Aysem $aysem){
        
    	//get latest collection
    	$collection_objects = Collection::where('aysem',$aysem->aysem)->orderBy('created_at','desc')->get();

        $collections = [];
        $last_collection = [];
        
        foreach($collection_objects as $collection){
            
            $enrollee_statistics = $collection->enrolleeStatistics()->get();

            $statistics=[];
            foreach($enrollee_statistics as $es){
                $statistics[$es->department_id] = [
                    'graduate' => $es->graduate,
                    'undergraduate' => $es->undergraduate
                ];                  
            }

            $allocations =  $this->computeAllocations($collection->amount,$statistics); 
            $dept_ids = array_keys($allocations);

            $departments = Department::find($dept_ids);

            
            $collections[$collection->id]['amount'] = $collection->amount ;
            $collections[$collection->id]['allocations'] = $allocations ;
            $collections[$collection->id]['statistics'] = $statistics ;
            $collections[$collection->id]['aysem'] = $aysem ;
            $collections[$collection->id]['is_adjustment'] = $collection->is_adjustment ;
            $collections[$collection->id]['created_at'] = $collection->created_at; 

            if(count($last_collection) == 0){
               $last_collection = $collections[$collection->id];
            }
        }
    	
    	$current_aysem = Aysem::current();
        $depts_with_percent = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',True)
                                    ->get();

        $depts_with_collection = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',False)
                                    ->get();
    
        $aysem_collections = DB::table('collections')->distinct()->pluck('aysem');
    	
    	return view('collection.show',compact('aysem_collections','collections','aysem', 'departments','current_aysem',
                    'depts_with_collection', 'depts_with_percent','last_collection'));
    }

    function view_individual($id){
        
        $collection_object = Collection::find($id);
        $enrollee_statistics = $collection_object->enrolleeStatistics()->get();

        $collection=[];
        $statistics=[];
        foreach($enrollee_statistics as $es){
            $statistics[$es->department_id] = [
                'graduate' => $es->graduate,
                'undergraduate' => $es->undergraduate
            ];                  
        }

        $allocations =  $this->computeAllocations($collection_object->amount,$statistics); 
        $dept_ids = array_keys($allocations);
        $departments = Department::find($dept_ids);

        $collection_id = $collection_object->id;
        $collection['amount'] = $collection_object->amount ;
        $collection['allocations'] = $allocations ;
        $collection['statistics'] = $statistics ;
        // $collection['aysem'] = $aysem ;
        $collection['is_adjustment'] = $collection_object->is_adjustment ;
        $collection['created_at'] = $collection_object->created_at; 

        $depts_with_percent = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',True)
                                    ->get();

        $depts_with_collection = DB::table('departments')
                                    ->where('is_from_book_fund',True)
                                    ->where('is_percent_based',False)
                                    ->get();
        $first_panel=True;

        return view('collection._collection_view',compact('first_panel','collection_id', 'departments','current_aysem',
                    'depts_with_collection', 'depts_with_percent','collection'));
    }

    /**
    *	Creates a new collection
    */
    function store(Request $request){

		$users = \App\User::all();
		
		$message = 'Library Fund Management System account '. Auth::user()->username .' made a new collection for '. Aysem::current()->short_name .'.';

		foreach($users as $user){
			$user->message = $message;
			$user->request = ['Collected Amount from Main Library' => $request->amount . ' PHP'];
			if($user->email){
				Mail::send('reminder', ['user' => $user], function ($m) use ($user) {
					$m->to($user->email)->subject('New Collection');
				});
			}
		}
    	$aysem = Aysem::current();
    	$amount = floatval($request->amount) ;  	

        //validation
        $validation_rules =  [
            'amount' => 'required'
        ];
    	$this->validate($request,$validation_rules);

        //validate that this is the first entry in Collections table
        $is_first_collection = Collection::isFirstCollectionForTheSem($aysem);
        $is_adjustment = !$is_first_collection;
        if($is_first_collection){
            $transactiontype = AccountTransactions::COLLECTION();
            $parent_id = null;
        }else{
            $transactiontype = AccountTransactions::ADJUSTMENT();
            $latest_collection = Collection::where('aysem',$aysem->aysem)->orderBy('created_at', 'desc')->first();
            $parent_id = $latest_collection->id;
        }

        // insert entries in collectionb and enrollmentstatistics
        $collection = Collection::create([
                'aysem'=>$aysem->aysem , 
                'amount' => $amount,
                'is_adjustment' => $is_adjustment,
                'parent_id'=> $parent_id
        ]);

        //insert statistics
        $statistics = $request->statistics;
        $success = $this->store_enrollment_statistics($statistics,$collection);
        if(!$success){
            session()->flash('alert-danger', 'No students recorded!');
            return redirect()->action('CollectionController@index')->with('danger', 'No students recorded!');
        }

        //compute old and new allocations
        if($is_adjustment){
            $old_amount = $latest_collection->amount;
            $old_statistics_obj = $latest_collection->enrolleeStatistics()->get();
            $old_statistics=[];
            foreach ($old_statistics_obj as $key => $obj) {
                $old_statistics[$key+1]['undergraduate'] = $obj->undergraduate;
                $old_statistics[$key+1]['graduate'] = $obj->graduate;
            }
            $old_allocations = $this->computeAllocations($old_amount,$old_statistics);
            $allocations = $this->computeAllocations($amount,$statistics);
            
            foreach ($allocations as $dept_id => $value) {
                $allocations[$dept_id] = $allocations[$dept_id] - $old_allocations[$dept_id];
            }

        }else{
            $allocations = $this->computeAllocations($amount,$statistics); 
        }
     
        
        //insert allocation as transactions
		foreach($allocations as $dept_id => $allocation){

            if($allocation > -0.01 and $allocation < 0.01){
                continue;       // do not insert if there's no significant change
            }

            $department = \App\Department::find($dept_id);  
            $last_account_transaction = $department->last_account_transaction();
       		
			$input = [				
				'department_id' => $dept_id,
				'transaction_type_id' =>$transactiontype,
				'amount' => floatval($allocation),
                'balance' => $last_account_transaction->balance + floatval($allocation),
                'aysem' => Aysem::current()->aysem,
                'collection_id' => $collection->id,
                'parent_account_transaction_id'=>$last_account_transaction->id

			];		
			AccountTransactions::create($input);
		}

        session()->flash('alert-success', 'Collection entries recorded!');
		return redirect()->action('CollectionController@index')->with('success', 'Collection recorded!');
		
    }

    private function store_enrollment_statistics($statistics,$collection){

        //count # of students
        $total_students = 0;
        foreach($statistics as $department_id => $department){
            $total_students += $department['undergraduate'];
            $total_students += $department['graduate'];
        }

        if($total_students == 0){
            return False;
        }
         
        foreach($statistics as $department_id => $department){
            $input = [
                'aysem' => $collection->aysem,
                'collection_id' => $collection->id,
                'department_id' => $department_id,
                'undergraduate' => $department['undergraduate'],
                'graduate' => $department['graduate']
            ];
            $dept_statistics = EnrolleeStatistics::create($input);
        }
        return True;
    }

     /**
        @parameter $statistics[dept_id][udnergraduate|graduate] = count
        @return $allocation[dept_id] = amount 
    */
    private function computeAllocations($amount, $statistics){

        //compute amount to allocate per dept
        $percent_reserved =  floatval( DB::table('departments')->sum('percent_allocation') ) / 100 ;
        $amount_reserved_to_percentage = $amount * $percent_reserved;
        $amount_reserved_to_divide = $amount * (1 - $percent_reserved);

        $total_weight = 0;
        $weights = [];
        $allocations = [];

        foreach($statistics as $department_id => $department){
            $total_weight +=  intval($department['undergraduate'])*self::UNDERGRAD_WEIGHT/self::TOTAL_WEIGHT;
            $total_weight +=  intval($department['graduate'])*self::GRAD_WEIGHT/self::TOTAL_WEIGHT;
            $weights[$department_id] = [
                'ug' => intval($department['undergraduate'])*self::UNDERGRAD_WEIGHT/self::TOTAL_WEIGHT,
                'g' =>  intval($department['graduate'])*self::GRAD_WEIGHT/self::TOTAL_WEIGHT
            ];
        }

        if($total_weight == 0){
            // No weights 
            return $allocations;
        }
        foreach ($weights as $department_id => $weight) {
            $allocations[$department_id] = $amount_reserved_to_divide * ($weight['ug'] + $weight['g']) / $total_weight;
        }


        $dept_with_percentage_allocation = Department::whereNotNull('percent_allocation')->get();
        foreach($dept_with_percentage_allocation as $dept){
            if($dept->percent_allocation > 0){
                $allocations[$dept->id] = $amount * floatval($dept->percent_allocation)/100;
            }
             
        }
            
        return $allocations;
    }

    function adjustments(Aysem $aysem){


    }

    function submitAdjustments(){

    }

}
