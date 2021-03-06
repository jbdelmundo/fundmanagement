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
			$sem = $request->session()->get('active_aysem',\App\Aysem::current()->aysem );
			$aysem = Aysem::where('aysem',$sem)->first();
        }else{
			$sem = $request->session()->get('active_aysem',\App\Aysem::current()->aysem );
			$aysem = Aysem::where('aysem',$sem)->first();
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
            $purchased[$key] = $value->where('status',Requests::APPROVED);   //filter only those that are deducted
        }
		
        $refunded = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $refunded[$key] = $value->where('status',Requests::DISCOUNTED);   //filter only those that are endorsed
        }
    	
    	return view('refunds.index',compact('user','departments','department','aysem', 'requests_this_sem','purchased','refunded'));
    }

	function create(Request $formrequest){
        $request = Requests::findOrFail($formrequest->request_id);
		
        $maxrefund = $request->total_quote_price;

		$validation_rules = ['refund'=>"required|min:1|max:$maxrefund|numeric"];
		$this->validate($formrequest,$validation_rules);
		
		
        //update request status to refunded
        if($maxrefund == $request->total_quote_price){
            $request->status = Requests::REFUNDED;          //full refund, item was not purchased
        }else{
            $request->status = Requests::DISCOUNTED;        //item received at a discount
        }
        $request->total_bid_price = $request->total_quote_price - $formrequest->refund;
        $request->save();
		
		
        $department = Department::find($request->department_id);                        
        $last_account_transaction = $department->last_account_transaction();

		$transaction = [];
        $transaction['department_id'] = $request->department_id; 
        $transaction['request_id'] = $request->id; 
        $transaction['amount'] = $formrequest->refund; 
        $transaction['balance'] = $last_account_transaction->balance + $formrequest->refund;
        $transaction['aysem'] = Aysem::current()->aysem;
        $transaction['transaction_type_id'] = 'R';
        $transaction['parent_account_transaction_id'] = $last_account_transaction->id;
		
		$account_transactions = \App\AccountTransactions::create($transaction);		
        $account_transactions->save();
        

        session()->flash('alert-success', 'Item is redunded and credited back to your account!');
        return redirect('refunds');
    }
}
