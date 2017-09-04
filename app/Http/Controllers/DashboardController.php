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
        // $beginning_balance = 1002200;
        // $current_balance = 2700;
        // $transactions = [ 
        //     ["created_at"=>'1/02/17',
        //      "transaction_type"=>'Collection',
        //      "amount"=>2000,
        //      "balance"=>3000
        //     ],
        //     ["created_at"=>'1/03/17',
        //      "transaction_type"=>'Purchase',
        //      "amount"=>300,
        //      "balance"=>2700
        //     ]
        // ];
        // $total_balance = 2700;
        /*                     */
        $user = Auth::user();
        if(is_null($user)){
			return redirect('');			
		}
		elseif(Auth::user()->isLibrarian()){
			$active_department_id = $request->session()->get('active_dept_id',1) ; 
			$department = Department::find($active_department_id);
            $departments = Department::all();           // For dropdown
		}
		else{
			$department = Department::find($user->department_id);
		}
		
		
        
		$records_to_fetch = 100;
        $current_aysem = $request->session()->get('active_aysem',Aysem::current()->aysem);
        $current_aysem = Aysem::where('aysem',$current_aysem)->first();
        $aysem = $current_aysem;
        
        

        $beginning_balance = Account::where('department_id', $department->id)
                                    ->where('aysem',$current_aysem->aysem)
                                    ->pluck('begining_balance')
                                    ->first();
							
        $current_balance = $department->account($current_aysem)                                
						             ->currentBalance();
							
        $account_id = $department->account($current_aysem)                                
							->id;
		
		$transactionss = AccountTransactions::where('department_id',$department->id)
											-> where('account_id',$account_id)
											-> orderby('created_at','asc')
											->get()
											->toArray();
		
        $transactions = [];
		$balance = $beginning_balance;
        foreach ($transactionss as $key => $value) {
            $value['balance'] = $balance + $value['amount'];
			$balance = $value['balance'];
            $transactions[$key] = $value;
        }
		
		// dd($beginning_balance, $transactions,$current_balance);
		
		$requests_this_sem = [
            \App\Requests::BOOK =>   $department->bookRequestsForSem($aysem),
            \App\Requests::EBOOK =>   $department->ebookRequestsForSem($aysem),
            \App\Requests::JOURNAL =>   $department->journalRequestsForSem($aysem),
            \App\Requests::MAGAZINE =>   $department->magazineRequestsForSem($aysem),
            \App\Requests::ERESOURCE =>   $department->eresourceRequestsForSem($aysem),
            \App\Requests::SUPPLIES =>   $department->suppliesRequestsForSem($aysem),
            \App\Requests::EQUIPMENT =>   $department->equipmentRequestsForSem($aysem),
            \App\Requests::OTHER =>   $department->otherRequestsForSem($aysem)
        ];

                
	
                
       return view('dashboard.dashboard',compact('requests_this_sem','active_department_id','departments','beginning_balance','current_balance','transactions', 'department', 'user','current_aysem','aysem', 'created_at'));
       
    }
    
}
