<?php

namespace App\Http\Controllers;

use App\Http\Requests;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Aysem;
use App\Department;
use App\AccountTransactions;
use App\Account;
use Illuminate\Support\Facades\DB;

class ApprovalController extends Controller
{
    public function index(Request $request)
    {		
 	    	$active_department_id = $request->session()->get('active_dept_id', 1);
    		$user = Auth::user();
 	    	$departments = Department::all();
 	    	$user->department_id=$active_department_id;
 	   		$department = Department::find($user->department_id);
 	    	$current_aysem = Aysem::current();
 
 	    	$beginning_balance = 200000;
 	    	$current_balance = 200000;
 

        /* Hardcoded variables */
        $endorsements = [ 
            'B' => [ 'request_id'=> 1,
            		  'title' => 'some title',
            		  'qty' => 20,
            		  'unit_quote_price'=>10.0
            		],
            'E' => [ 'request_id'=> 2,
            		  'title' => 'some title2',
            		  'qty' => 19,
            		  'unit_quote_price'=>11.0
            		],
            'M' => [ 'request_id'=> 3,
            		  'title' => 'some title3',
            		  'qty' => 18,
            		  'unit_quote_price'=>12.0
            		],
            'Q' => [ 'request_id'=> 4,
            		  'description' => 'some description1',
            		  'qty' => 17,
            		  'unit_quote_price'=>13.0
            		],
            'S' => [ 'request_id'=> 5,
            		  'description' => 'some description2',
            		  'qty' => 16,
            		  'unit_quote_price'=>14.0
            		],
            'O' => [ 'request_id'=>6,
            		  'description' => 'some description3',
            		  'qty' => 15,
            		  'unit_quote_price'=>15.0
            		]										
        ];
        /***********************/

          return view('approval.approval', compact('active_department_id','departments', 'beginning_balance', 'current_balance', 'endorsements', 'department', 'user', 'current_aysem'));      
    }

    function create(Request $request){
 		dd($request);
 	}
}
