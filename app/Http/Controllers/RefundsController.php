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
class RefundsController extends Controller
{
    //
	
	function index(Request $request){
    	$user = Auth::user();
        if($user->isLibrarian()){
			$department_id = $request->session()->get('active_dept_id',1 ) ;    
			$sem = $request->session()->get('active_aysem',1 );
			$aysem = Aysem::where('aysem',$sem)->first();
        }else{
            $department_id = $user->department->id;
        }
        $department = Department::find($department_id);
        $dept = $department; 
        
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
        $purchased = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $purchased[$key] = $value->where('status',Requests::PURCHASED);   //filter only those that are purchased
        }
    	return view('refunds.index',compact('user','departments','department','aysem', 'requests_this_sem','purchased'));
    }
	function create(Request $formrequest){
        $request = Requests::findOrFail($formrequest->request_id);
		
		$validation_rules = ['refund'=>'required|min:1'];
		$this->validate($formrequest,$validation_rules);
		
		
        //update request status to refunded
        $request->status = Requests::REFUNDED;
        $request->total_bid_price = $request->total_quote_price - $formrequest->refund;
        $request->save();
		
		$account_id = Account::where('department_id',$request->department_id)
								-> orderby('created_at','desc')
								->first()->id;
		$transaction = [];
        $transaction['department_id'] = $request->department_id; 
        $transaction['account_id'] = $account_id; 
        $transaction['request_id'] = $request->id; 
        $transaction['amount'] = $formrequest->refund; 
        $transaction['remarks'] = 'NONE';
        $transaction['transaction_type_id'] = 'R';
		
		$account_transactions = \App\AccountTransactions::create($transaction);		
        $account_transactions->save();
        
        return redirect('refunds');
    }
}