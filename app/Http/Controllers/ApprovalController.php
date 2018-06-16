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


        $approved = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $approved[$key] = $value->whereIn('status',[Requests::APPROVED,Requests::REFUNDED,Requests::DISCOUNTED])->where('department_id',$active_department_id);   //filter only those that are approved, refunded (deducted already)
        }
        
        $rejects = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $rejects[$key] = $value->where('status',Requests::REJECTED_APPROVE)->where('department_id',$active_department_id);   //filter only those that are endorsed
        }

		// dd($endorsements);
    	return view('approval.index',compact('user','departments','department','aysem','endorsements',
            'approved','rejects','active_department_id'
            ));
    }
	
    function create(Request $formrequest){

    	/*
			Get Request Item -> set approved
			Insert AccountTransactions
    	*/
		
        $request = Requests::findOrFail($formrequest->request_id);
		
		
		// Send Notification to users

		// $category = $request->category_id;

		// $category_item = $this->find_item($category, $request->item_id) 
		// $category = $category_item[0]
		// $item = $category_item[1]
		// $users = \App\User::where('department_id',$request->department_id)->get()->toArray();
		
			
			
        $request_endorsement_id = RequestEndorsement::where('request_id',$formrequest->request_id)
        								->get()->toArray()[0]['id'];
        $request_endorsement = RequestEndorsement::findOrFail($request_endorsement_id);
       
        //update request status to for purchase

        //check if already approved
        if($request->status != Requests::ENDORSED){
            session()->flash('alert-danger', 'Request is not available for approval. Your balance is not deducted');
            return redirect('approval');
        }

        $request->status = Requests::APPROVED;
        $request->save();
        

        //update request endorsement approved_by
        $request_endorsement->approved_by = Auth::user()->id; 
        $request_endorsement->save();

        $department = Department::find($request->department_id);
        $last_account_transaction = $department->last_account_transaction();


		$transaction = [];
        $transaction['department_id'] = $request->department_id; 
    
        $transaction['request_id'] = $request->id; 
        $transaction['amount'] = $request->total_quote_price*-1;
        $transaction['balance'] = $last_account_transaction->balance + ($request->total_quote_price*-1); 
        $transaction['transaction_type_id'] = 'P';
        $transaction['aysem'] = Aysem::current()->aysem;
        $transaction['parent_account_transaction_id'] = $last_account_transaction->id;
		
		$account_transactions = \App\AccountTransactions::create($transaction);		

        $account_transactions->save();
        
        session()->flash('alert-success', 'Request is approved and deducted to your account!');
        return redirect('approval');
    }

    function reject(Request $formrequest){        

        $request = Requests::findOrFail($formrequest->request_id);
        
        $category = $request->category_id;
        $request->status = Requests::REJECTED_APPROVE;
        $request->reject_reason = $formrequest->reject_reason;
        $request->save();

        // session()->flash('alert-warning', 'Request was rejected! Reason:'.$formrequest->reject_reason);
        return 1;
    }

    function remove($request_id){       
        
        //update the status to endorsed
        $request = Requests::find($request_id);
        $request->status = Requests::ENDORSED;
        $request->save();
        
        return redirect(url('approval'));
    }

    //verify if user is allowed to take action
    private function verify_department(){
        $active_department_id = $request->session()->get('active_dept_id',1) ; 
        $department = Department::find($active_department_id);
    }

    private function find_item($category, $item_id){
    	$category_name = [];
    	$category_name['B'] = 'book';
    	$category_name['E'] = 'eBook';
    	$category_name['J'] = 'journal';
    	$category_name['M'] = 'magazine';
    	$category_name['R'] = 'eResource';
    	$category_name['Q'] = 'equipment';
    	$category_name['S'] = 'supply';
    	$category_name['O'] = 'material';

    	switch($category){
			case 'B':				
				$item = Book::find($request->item_id)->title;
				break;
			case 'E':
				$item = Book::find($request->item_id)->title;
				break;
			case 'J':
				$item = Magazine::find($request->item_id)->title;
				break;
			case 'M':
				$item = Magazine::find($request->item_id)->title;
				break;
			case 'R':
				$item = Eresource::find($request->item_id)->title;
				break;
			case 'Q':
				$item = OtherMaterial::find($request->item_id)->description;
				break;
			case 'S':
				$item = OtherMaterial::find($request->item_id)->description;
				break;
			case 'O':
				$item = OtherMaterial::find($request->item_id)->description;
				break;
		}
		$category = $category_name[$category];
		return [$category,$item];
    }

    private function notify_users($users, $category_name, $request, $item){
    	foreach($users as $user){
				
				$message = 'A new '.$category_name.' endorsement was approved by the Library Fund Management System account '.Auth::user()->username.' for the '.\App\Department::find($request->department_id)->full_name.'.';
				$user['message'] = $message;
				$user['request'] = ['Title/Descrition' => $item,
									'Date Requested' => $request->created_at->format('d-M-Y'),
									'Recommended By' => $request->recommendedby];
				if($user['email']){
					Mail::send('reminder', 
								['user' => $user],
								function ($m) use ($user) {
									$m->to($user['email'])->subject('Request Approval');
								}
					);
				}
			}
    }
}
