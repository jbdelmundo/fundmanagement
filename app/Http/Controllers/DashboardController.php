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
    public function index(Request $request)
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



        $departments = Department::all();
        $records_to_fetch = 100;
        $department = Department::find($user->department_id);
        $current_aysem = Aysem::current();

        $beginning_balance = 1000;
        $current_balance = 2700;
        $active_department_id = $request->session()->get('active_dept_id',0 ) ;  
        $transactions=[
            [
                'created_at' => '01/02/17',
                'transactiontype_id' => 'C',
                'Amount' => 2000,
                'Balance' => 3000

            ],

            [
                'created_at' => '01/03/17',
                'transactiontype_id' => 'P',
                'Amount' => 300,
                'Balance' => 2700

            ]

        ];


                
       return view('dashboard.dashboard',compact('active_department_id','departments','beginning_balance','current_balance','transactions', 'department', 'user','current_aysem', 'created_at'));
       // return view('dashboard');
    }

    
}
