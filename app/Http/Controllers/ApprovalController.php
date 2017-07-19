<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Aysem;
use App\Department;
use App\Requests;
use App\RequestEndorsement;
use App\Account;
use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;
class ApprovalController extends Controller
{
    //
	function index(Request $request){
		
        $user = Auth::user();
        if(is_null($user)){
			return redirect('');			
		}
		elseif(Auth::user()->isLibrarian()){
			$active_department_id = $request->session()->get('active_dept_id',1) ; 
			$department = Department::find($active_department_id);
		}
		else{
			$active_department_id = $user->department_id;
			$department = Department::find($user->department_id);
		}
    	$aysem = Aysem::current();
		
		$departments = Department::all();
        $dept = $user->department()->first();
        $department = $dept;
        $all_requests_this_sem = [
            Requests::BOOK =>   	$dept->bookRequestsForSem($aysem),
            Requests::EBOOK =>   	$dept->ebookRequestsForSem($aysem),
            Requests::JOURNAL =>   	$dept->journalRequestsForSem($aysem),
            Requests::MAGAZINE =>   $dept->magazineRequestsForSem($aysem),
            Requests::ERESOURCE =>  $dept->eresourceRequestsForSem($aysem),
            Requests::SUPPLIES =>   $dept->suppliesRequestsForSem($aysem),
            Requests::EQUIPMENT =>  $dept->equipmentRequestsForSem($aysem),
            Requests::OTHER =>   	$dept->otherRequestsForSem($aysem)
        ];
        $endorsements = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $endorsements[$key] = $value->where('status',Requests::ENDORSED)->where('department_id',$active_department_id);   //filter only those that are endorsed
        }
		
    	return view('approval.index',compact('user','departments','department','aysem','endorsements','active_department_id'
            ));
    }
	
    function create(Request $formrequest){
        $request = Requests::findOrFail($formrequest->request_id);
        $request_endorsement_id = RequestEndorsement::where('request_id',$formrequest->request_id)->get()->toArray()[0]['id'];
        $request_endorsement = RequestEndorsement::findOrFail($request_endorsement_id);
        //update request status to for purchase
        $request->status = Requests::FOR_PURCHASE;
        $request->save();
		
        //update request endorsement approved_by
        $request_endorsement->approved_by = Auth::user()->id; 
        $request_endorsement->save();
		$account_id = Account::where('department_id',$request->department_id)
								-> orderby('created_at','desc')
								->get()->toArray();
		$transaction = [];
        $transaction['department_id'] = $request->department_id; 
        $transaction['account_id'] = $account_id[0]['id']; 
        $transaction['request_id'] = $request->id; 
        $transaction['amount'] = $request->total_quote_price*-1; 
        $transaction['remarks'] = 'NONE';
        $transaction['transaction_type_id'] = 'P';
		
		$account_transactions = \App\AccountTransactions::create($transaction);		
// dd($transaction);
        $account_transactions->save();
        
        return redirect('approval');
    }
}
