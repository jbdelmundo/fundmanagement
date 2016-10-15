<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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

	

    function index(){
    	$aysems = Aysem::all();
    	$collections = DB::table('collections')->distinct()->pluck('aysem');

    	$depts_with_collection = DB::table('departments')->where('percent_allocation',null)->get();

    	$current_aysem = Aysem::current();

    	return view('collection.index',compact('aysems', 'collections','depts_with_collection','current_aysem'));
    }

    function show(Aysem $aysem){
        $collections = DB::table('collections')->distinct()->pluck('aysem');
    	//get latest colletion
    	$collection = Collection::where('aysem',$aysem->aysem)->orderBy('created_at')->first();

    	$enrollee_statistics = $collection->enrolleeStatistics()->get();

    	$statistics=[];
    	foreach($enrollee_statistics as $es){
    		$statistics[$es->department_id] = [
    			'graduate' => $es->graduate,
    			'undergraduate' => $es->undergraduate
    		];    		   		
    	}

    	$allocations =  Collection::computeAllocations($collection->amount,$statistics); 
    	$dept_ids = array_keys($allocations);

    	$departments = Department::find($dept_ids);
    	
    
    	
    	return view('collection.show',compact('collections','aysem','collection','allocations','departments','statistics'));
    }

    /**
    *	Creates a new collection
    */
    function store(Request $request){
    	$validation_rules =  [
	        'amount' => 'required'
	    ];

    	
    	
    	$aysem = Aysem::current();
    	$amount = floatval( $request->amount) ;
    	$statistics = $request->statistics;		//array statistics[deptid][undergraduate]


    	 $this->validate($request,$validation_rules);


    	//validate that this is the first entry in Collections table
		$is_first_collection = Collection::isFirstCollection($aysem);

		if($is_first_collection){

			$collection = Collection::create(['aysem'=>$aysem->aysem , 'amount' => $amount ]);
			

			//save enrollee statistics
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


			$allocations =  Collection::computeAllocations($amount,$statistics);
			$deb = [];
			foreach($allocations as $dept_id => $allocation){
				
				$input = [
					'aysem' => $aysem->aysem,
					'department_id' => $dept_id,
					'transaction_type_id' => AccountTransactions::COLLECTION(),
					'amount' => $allocation,
					'balance' => floatval( AccountTransactions::currentBalance($aysem->aysem,$dept_id) ) + floatval($allocation)

				];
			
				AccountTransactions::create($input);
			}
		
			return redirect()->action('CollectionController@index')->with('success', 'Collection recorded!');
			
		}else{
			return redirect()->action('CollectionController@index');
		}


    }

    function adjustments(Aysem $aysem){


    }

    function submitAdjustments(){

    }

}
