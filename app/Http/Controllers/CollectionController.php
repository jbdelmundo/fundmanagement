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
        $collections = DB::table('collections')->distinct()->pluck('aysem');
    	//get latest collection
    	$collection = Collection::where('aysem',$aysem->aysem)->orderBy('created_at')->first();


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
    	
    
    	
    	return view('collection.show',compact('collections','aysem','collection','allocations','departments','statistics'));
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
        if($is_first_collection){
            $transactiontype = AccountTransactions::COLLECTION();
        }else{
            $transactiontype = AccountTransactions::ADJUSTMENT();
        }


        // insert entries in collectionb and enrollmentstatistics
        $collection = Collection::create(['aysem'=>$aysem->aysem , 'amount' => $amount ]);
        //insert statistics
        $statistics = $request->statistics;
        $success = $this->store_enrollment_statistics($statistics,$collection);
        if(!$success){
            session()->flash('alert-danger', 'No students recorded!');
            return redirect()->action('CollectionController@index')->with('danger', 'No students recorded!');
        }

        //compute allocations
        $allocations = $this->computeAllocations($amount,$statistics); 
        
        
        //insert allocation as transactions
		foreach($allocations as $dept_id => $allocation){

            $department = \App\Department::find($dept_id);  
            $last_account_transaction = $department->last_account_transaction();
       		
			$input = [				
				'department_id' => $dept_id,
				'transaction_type_id' =>$transactiontype,
				'amount' => floatval($allocation),
                'balance' => $last_account_transaction->balance + floatval($allocation),
                'aysem' => Aysem::current()->aysem,
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
