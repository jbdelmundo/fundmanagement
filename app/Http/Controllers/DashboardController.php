<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Aysem;
use App\Department;
use App\AccountTransactions;


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
			$active_department_id = $request->session()->get('active_dept_id',1) ; 
			$department = Department::find($active_department_id);
            $departments = Department::all();           // For dropdown
		}
		else{
			$department = Department::find($user->department_id);
		}
		
		
        
		$records_to_fetch = 20;
        $current_aysem = $request->session()->get('active_aysem',Aysem::current()->aysem);
        $current_aysem = Aysem::where('aysem',$current_aysem)->first();
        $aysem = $current_aysem;
        

							
        $current_balance = $department->last_account_transaction()->balance;
							
        
		
		$transactions = AccountTransactions::where('department_id',$department->id)
											-> where('aysem',$aysem->aysem)
											-> orderby('created_at','desc')
                                            ->limit($records_to_fetch)
											->get();
		
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

                
	    $types = [
            'C' => 'COLLECTION',
            'P' => 'PURCHASE',
            'A' => 'ADJUSTMENT',
            'R' => 'REFUND',
            'I' => 'INITIAL'
        ];
                
       return view('dashboard.dashboard',compact('requests_this_sem','active_department_id','departments','current_balance','transactions', 'department', 'user','current_aysem','aysem', 'types'));
       
    }
    
}
