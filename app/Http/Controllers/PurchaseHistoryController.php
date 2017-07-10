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
				$sem = $request->session()->get('active_aysem',\App\Aysem::current()->aysem );
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

		$subjects = RequestEndorsement::join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																 ->select('request_endorsements.*','requests.*')->get();
																
		$checker = 0.00;

		$search = \Request::get('subject');

		$try = RequestEndorsement::with('request')->join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																->select('request_endorsements.*','requests.*')->where('subject','like', '%'.$search.'%')
																->get(); //pagkuha sa mga nasa search bar hahaha.



			
				// if(Request::get('seeall'))
					// {
						// return Redirect::to('/purchasehistory');
					// }
				// else{}

				// $boks = Requests::selectRaw('requests.*,books.*,request_endorsements.*,magazines.*,other_materials.*')->leftJoin('books', 'requests.id', '=' , 'books.request_id')
										// ->leftJoin('magazines', 'requests.id', '=' , 'magazines.request_id')->leftJoin('other_materials', 'requests.id', '=' , 'other_materials.request_id')->leftJoin('request_endorsements', 'requests.id', '=' , 'request_endorsements.request_id')
										// ->where('requests.status', '=', '4')->get(); //lahat ng purchased. pero dipa nkukuha yung sa magazines, others etc. papasa sa all view.
										 // dd($boks);
			return view('purchasehistory.index',compact('user','departments','department','aysem', 'requests_this_sem','purchased','all','checker','search','try','subjects'));
    }
	
	function seeall(){
	$checker = 0.00;
			$boks = Requests::selectRaw('requests.*,books.*,request_endorsements.*,magazines.*,other_materials.*')->leftJoin('books', 'requests.id', '=' , 'books.request_id')
										->leftJoin('magazines', 'requests.id', '=' , 'magazines.request_id')->leftJoin('other_materials', 'requests.id', '=' , 'other_materials.request_id')->leftJoin('request_endorsements', 'requests.id', '=' , 'request_endorsements.request_id')
										->where('requests.status', '=', '4')->get(); //lahat ng purchased. pero dipa nkukuha yung sa magazines, others etc. papasa sa all view.
										// dd($boks);
										$requests = Requests::all();
										
		return view('purchasehistory.seeall', compact('boks','checker','requests'));
	
	}
	
	
}
