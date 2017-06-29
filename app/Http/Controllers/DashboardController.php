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
        $user = Auth::user();
        if(is_null($user)){
			return redirect('');			
		}
		elseif(Auth::user()->isLibrarian()){
			$department_id = $request->session()->get('active_dept_id',1) ;     
			$department = Department::find($department_id);
		}
		else{
			$department = Department::find($user->department_id);
		}


        $records_to_fetch = 100;
        $current_aysem = Aysem::current();

        $begining_balances = array_column(Account::find($department->account($current_aysem))->toArray(),'begining_balance');
        foreach ($begining_balances as $key => $begining_balance) {
			if($begining_balances[$key] == 0) {
				unset($begining_balances[$key]);
			}
		}
							
        $current_balance = $department->account($current_aysem)                                
							->currentBalance();
							
        $account_id = $department->account($current_aysem)                                
							->id;

		
		$transactions = AccountTransactions::where('department_id',$department->id)
											-> where('account_id',$account_id)
											-> orderby('created_at','ase')
											->get()
											->toArray();
		
		
		// dd($begining_balance, $transactions,$current_balance);
                
        return view('dashboard.dashboard',compact('user','department', 'balance_history','balance_chart' ,'aysem_summary','current_balance','begining_balance','transactions'));
    }

    public function balancehistory()
    {
        
        return view('balance');
    }

    public function summaryOfExpenses(){

        $user = Auth::user();
        if(is_null($user) || is_null($user->department_id)){abort(404);}



        $records_to_fetch = 100;
        $department = Department::find($user->department_id);
        $current_aysem = Aysem::current();
    }
}
