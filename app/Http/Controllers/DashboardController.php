<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Auth;
use App\Aysem;
use App\Department;
use App\AccountTransactions;

use App\Account;
use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;

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
		
		
        
		
        $current_aysem = $request->session()->get('active_aysem',Aysem::current()->aysem);
        $current_aysem = Aysem::where('aysem',$current_aysem)->first();
        $aysem = $current_aysem;
        

							
        $current_balance = $department->last_account_transaction()->balance;
							
        
		$records_to_fetch = 20;
		$transactions = AccountTransactions::where('department_id',$department->id)
											-> where('aysem',$aysem->aysem)
											-> orderby('created_at','desc')
                                            ->limit($records_to_fetch)
											->get();
        
        $purchased_items = [];
        $collection_data = [];
        foreach ($transactions as $transaction) {
            if(in_array( $transaction->transaction_type_id , ['P','R'])) {
                $purchased_items[$transaction->id] = $this->view_purchase($transaction->id);
            }elseif(in_array( $transaction->transaction_type_id , ['P','R'])) {
                $collection_data[$transaction->id] = $this->view_purchase($transaction->id);
            }
        }

        foreach ($transactions as $transaction) {
            if(in_array( $transaction->transaction_type_id , ['P','R'])) {
                $purchased_items[$transaction->id] = $this->view_purchase($transaction->id);
            }
        }
		
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
            'A' => 'COLLECTION ADJUSTMENT',
            'R' => 'REFUND',
            'I' => 'INITIAL',
            'M' => 'MANUAL'
        ];
                
       return view('dashboard.dashboard',compact('requests_this_sem','active_department_id','departments','current_balance','transactions','purchased_items', 'department', 'user','current_aysem','aysem', 'types'));
       
    }

    private function view_collection(){
        
    }
    private function view_purchase($transaction_id){
        //
        
        $account_transaction = AccountTransactions::find($transaction_id);

        if( !in_array( $account_transaction->transaction_type_id , ['P','R']) ) {
            return;
        }

        $request = \App\Requests::find($account_transaction->request_id);

        switch($request->category_id){
            case 'B':               
                $item = Book::find($request->item_id);
                break;
            case 'E':
                $item = Book::find($request->item_id);
                break;
            case 'J':
                $item = Magazine::find($request->item_id);
                break;
            case 'M':
                $item = Magazine::find($request->item_id);
                break;
            case 'R':
                $item = Eresource::find($request->item_id);
                break;
            case 'Q':
                $item = OtherMaterial::find($request->item_id);
                break;
            case 'S':
                $item = OtherMaterial::find($request->item_id);
                break;
            case 'O':
                $item = OtherMaterial::find($request->item_id);
                break;
        }

        $obj_merged = (object) array_merge((array) $request->toArray(), (array) $item->toArray());
        // $obj_merged->request_id = $request->id;
       
        return $obj_merged;
    }
    
}
