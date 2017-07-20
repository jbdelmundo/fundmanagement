<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use Mail;
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
        $endorsements = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $endorsements[$key] = $value->where('status',Requests::ENDORSED)->where('department_id',$active_department_id);   //filter only those that are endorsed
        }
		
    	return view('approval.index',compact('user','departments','department','aysem','endorsements','active_department_id'
            ));
    }
	
    function create(Request $formrequest){
		
        $request = Requests::findOrFail($formrequest->request_id);
		$category = $request->category_id;
		switch($category){
			case 'B':
				$category_name = 'book';
				$item = Book::find($request->item_id)->title;
				break;
			case 'E':
				$category_name = 'eBook';
				$item = Book::find($request->item_id)->title;
				break;
			case 'J':
				$category_name = 'journal';
				$item = Magazine::find($request->item_id)->title;
				break;
			case 'M':
				$category_name = 'magazine';
				$item = Magazine::find($request->item_id)->title;
				break;
			case 'R':
				$category_name = 'eResource';
				$item = Eresource::find($request->item_id)->title;
				break;
			case 'Q':
				$category_name = 'equipment';
				$item = OtherMaterial::find($request->item_id)->description;
				break;
			case 'S':
				$category_name = 'supply';
				$item = OtherMaterial::find($request->item_id)->description;
				break;
			case 'O':
				$category_name = 'material';
				$item = OtherMaterial::find($request->item_id)->description;
				break;
		}
		
		$users = \App\User::where('department_id',$request->department_id)->get()->toArray();
		
			foreach($users as $user){
				
				$message = 'A new '.$category_name.' endorsement was approved by the Library Fund Management System account '.Auth::user()->username.' for the '.\App\Department::find($request->department_id)->full_name.'.';
				$user['message'] = $message;
				$user['request'] = ['Title/Descrition' => $item,
									'Date Requested' => $request->created_at->format('d-M-Y'),
									'Recommended By' => $request->recommendedby];
				if($user['email']){
					Mail::send('reminder', ['user' => $user], function ($m) use ($user) {
						$m->to($user['email'])->subject('Request Approval');
					});
				}
			}
			
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
