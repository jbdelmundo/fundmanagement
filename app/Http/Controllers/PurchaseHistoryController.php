<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Auth;
use App\Aysem;
use App\Department;
use App\Requests;
use App\RequestEndorsement;
use App\Account;
use Illuminate\Support\Facades\DB;

class PurchaseHistoryController extends Controller
{

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
			$need=[];
			foreach ($all_requests_this_sem as $key => $value) {
				$purchased[$key] = $value->where('status',Requests::PURCHASED); 
			}

			// $subjects = RequestEndorsement::join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																// ->select('request_endorsements.*','requests.*')->get();
																
			$checker = 0.00;

				$search = \Request::get('subject');

			$try = RequestEndorsement::with('request')->join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																->select('request_endorsements.*','requests.*')->where('subject','like', '%'.$search.'%')->get(); //pagkuha sa mga nasa search bar hahaha.
			// $page = RequestEndorsement::with('subject')->findOrFail($search);
			 // dd($try);
			// dd($req_this_dept);
		// foreach($search as $key =>$subjects{
			// $need[$key] = $subjects->where('subject', 'like', '%'.$search.'%');
		// }

			return view('purchasehistory.index',compact('user','departments','department','aysem', 'requests_this_sem','purchased','all','checker','search','try'));
    }
	
	
}
