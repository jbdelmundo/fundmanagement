<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Aysem;
use App\Department;
use App\Requests;


use App\Book;

use App\Eresource;
use App\OtherMaterial;

use Illuminate\Support\Facades\Auth;


class ApprovalController extends Controller
{

    function index(Request $request){
	   	$user = Auth::user();
	    $departments = Department::all();
	    $department = Department::find($user->department_id);
	    $current_aysem = Aysem::current();

	    $beginning_balance = 200000;
	    $current_balance = 200000;

	    $active_department_id = $request->session()->get('active_dept_id', 0);
	    $endorsements = [
	    	'B' => 
	    		[
	    			'request_id' => 1,
	    			'title' => 'Title1',
	    			'qty' => 20,
	    			'unit_quote_price' => 10 
	    		],
	    	'E' => 
	    		[
	    			'request_id' => 2,
	    			'title' => 'Title2',
	    			'qty' => 20,
	    			'unit_quote_price' => 10 
	    		],
	    	'J' => 
	    		[
	    			'request_id' => 3,
	    			'title' => 'Title3',
	    			'qty' => 20,
	    			'unit_quote_price' => 10 
	    		],
	    	'M' => 
	    		[
	    			'request_id' => 4,
	    			'title' => 'Title4',
	    			'qty' => 20,
	    			'unit_quote_price' => 10 
	    		] 
	    ];

	       return view('approval.approval', compact('active_department_id', 'departments', 'beginning_balance', 'current_balance', 'endorsements', 'department', 'user', 'current_aysem'));
	    }

	function create(Request $request){
		dd($request);
	}
}