<?php
<<<<<<< HEAD

namespace App\Http\Controllers;

=======
namespace App\Http\Controllers;
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
use Illuminate\Http\Request;
use Auth;
use App\Aysem;
use App\Department;
use App\Requests;
use App\RequestEndorsement;
use App\Account;
<<<<<<< HEAD


=======
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;
<<<<<<< HEAD

=======
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
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
			$department = Department::find($user->department_id);
		}
<<<<<<< HEAD

    	$aysem = Aysem::current();

		
		$departments = Department::all();

=======
    	$aysem = Aysem::current();
		
		$departments = Department::all();
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
        $all_requests_this_sem = [
            Requests::BOOK =>   	$department->bookRequestsForSem($aysem),
            Requests::EBOOK =>   	$department->ebookRequestsForSem($aysem),
            Requests::JOURNAL =>   	$department->journalRequestsForSem($aysem),
            Requests::MAGAZINE =>   $department->magazineRequestsForSem($aysem),
            Requests::ERESOURCE =>  $department->eresourceRequestsForSem($aysem),
            Requests::SUPPLIES =>   $department->suppliesRequestsForSem($aysem),
            Requests::EQUIPMENT =>  $department->equipmentRequestsForSem($aysem),
            Requests::OTHER =>   	$department->otherRequestsForSem($aysem)
        ];
<<<<<<< HEAD

=======
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
        $endorsements = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $endorsements[$key] = $value->where('status',Requests::ENDORSED)->where('department_id',$active_department_id);   //filter only those that are endorsed
        }
		// dd($endorsements);
    	return view('approval.index',compact('user','departments','department','aysem','endorsements','active_department_id'
            ));
    }
	
    function create(Request $formrequest){
<<<<<<< HEAD

        $request = Requests::findOrFail($formrequest->request_id);

        $request_endorsement_id = RequestEndorsement::where('request_id',$formrequest->request_id)->get()->toArray()[0]['id'];
        $request_endorsement = RequestEndorsement::findOrFail($request_endorsement_id);


=======
        $request = Requests::findOrFail($formrequest->request_id);
        $request_endorsement_id = RequestEndorsement::where('request_id',$formrequest->request_id)->get()->toArray()[0]['id'];
        $request_endorsement = RequestEndorsement::findOrFail($request_endorsement_id);
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
        //update request status to for purchase
        $request->status = Requests::FOR_PURCHASE;
        $request->save();
		
        //update request endorsement approved_by
        $request_endorsement->approved_by = Auth::user()->id; 
        $request_endorsement->save();
<<<<<<< HEAD

=======
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
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
<<<<<<< HEAD

}
=======
}
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
