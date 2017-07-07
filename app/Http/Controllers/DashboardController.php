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
        if(is_null($user)){
			return redirect('');			
		}
		elseif(Auth::user()->isLibrarian()){
			$active_department_id = $request->session()->get('active_dept_id',1) ; 
			$department = Department::find($active_department_id);
		}
		else{
			$department = Department::find($user->department_id);
		}

		
		$departments = Department::all();
        
		$records_to_fetch = 100;
        $current_aysem = Aysem::current();

        $beginning_balances = array_column(Account::find($department->account($current_aysem))->toArray(),'begining_balance');
        foreach ($beginning_balances as $key => $beginning_balance) {
			if($beginning_balances[$key] == 0) {
				unset($beginning_balances[$key]);
			}
		}
							
        $current_balance = $department->account($current_aysem)                                
							->currentBalance();
							
        $account_id = $department->account($current_aysem)                                
							->id;

		
		$transactionss = AccountTransactions::where('department_id',$department->id)
											-> where('account_id',$account_id)
											-> orderby('created_at','ase')
											->get()
											->toArray();
		// foreach($transactions as $transaction){
			// $transaction['balance']= $beginning_balance + $transaction['amount'];
		// }
		
		
        $transactions = [];
		$balance = $beginning_balance;
        foreach ($transactionss as $key => $value) {
            $value['balance'] = $balance + $value['amount'];
			$balance += $value['balance'];
            $transactions[$key] = $value;
        }
		
		// dd($beginning_balance, $transactions,$current_balance);
		
		
                
	


                
       return view('dashboard.dashboard',compact('active_department_id','departments','beginning_balance','current_balance','transactions', 'department', 'user','current_aysem', 'created_at'));
       
    }

    
}
