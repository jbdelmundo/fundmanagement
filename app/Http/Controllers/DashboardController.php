<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Aysem;
use App\Department;
use App\AccountTransactions;
use App\Account;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
{
    public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        /* Hardcoded variables */
        $beginning_balance = 1000;
        $current_balance = 2700;
        $transactions = [ 
            ["created_at"=>'1/02/17',
             "transaction_type"=>'Collection',
             "amount"=>2000,
             "balance"=>3000
            ],
            ["created_at"=>'1/03/17',
             "transaction_type"=>'Purchase',
             "amount"=>300,
             "balance"=>2700
            ]
        ];
        $total_balance = 2700;
        /*                     */

        $user = Auth::user();
        $user->department_id=1;
        if(is_null($user) || is_null($user->department_id)){abort(404);}



        $records_to_fetch = 100;
        $department = Department::find($user->department_id);
        $current_aysem = Aysem::current();

          return view('dashboard.dashboard',compact('user','department','beginning_balance','current_balance','transactions','total_balance')); //while back end is not available      
    }

    
}
