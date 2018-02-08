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
				
			}else{
				$department_id = $user->department->id;
			}
			$sem = $request->session()->get('active_aysem',\App\Aysem::current()->aysem );
			$aysem = Aysem::where('aysem',$sem)->first();

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
			// dd($all_requests_this_sem);

			foreach ($all_requests_this_sem as $key => $value) {
				// dd($value);
				$purchased[$key] = $value->whereIn('status',[Requests::APPROVED , Requests::REFUNDED]);
			}

		$subjects = RequestEndorsement::join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																 ->select('request_endorsements.*','requests.*')->get();
		// dd($purchased);												
		$checker = 0.00;

		$search = \Request::get('subject');

		$try = RequestEndorsement::with('request')->join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																->select('request_endorsements.*','requests.*')->where('subject','like', '%'.$search.'%')
																->get(); //pagkuha sa mga nasa search bar hahaha.

			return view('purchasehistory.index',compact('user','departments','department','aysem', 'requests_this_sem','purchased','all','checker','search','try','subjects'));
    }
	
	function seeall(Request $request){

			
		$user = Auth::user();
			if($user->isLibrarian()){
				$department_id = $request->session()->get('active_dept_id',1 ) ;    
			}else{
				$department_id = $user->department->id;
			}
			$department = Department::find($department_id);
			$dept = $department; 

			$aysem = Aysem::all();
			$all_requests_this_sem = [
				Requests::BOOK =>   	Requests::where('category_id','B')->where('department_id',$dept->id)->get(),
				Requests::EBOOK =>   	Requests::where('category_id','E')->where('department_id',$dept->id)->get(),
				Requests::JOURNAL =>   	Requests::where('category_id','J')->where('department_id',$dept->id)->get(),
				Requests::MAGAZINE =>   Requests::where('category_id','M')->where('department_id',$dept->id)->get(),
				Requests::ERESOURCE =>  Requests::where('category_id','R')->where('department_id',$dept->id)->get(),
				Requests::SUPPLIES =>   Requests::where('category_id','S')->where('department_id',$dept->id)->get(),
				Requests::EQUIPMENT =>  Requests::where('category_id','Q')->where('department_id',$dept->id)->get(),
				Requests::OTHER =>   	Requests::where('category_id','O')->where('department_id',$dept->id)->get()
			];			
			$purchased = [];
			foreach ($all_requests_this_sem as $key => $value) {
				$purchased[$key] = $value->where('status',Requests::PURCHASED); 
			}
			$bookz = DB::table('books')
            ->select('books.*')
            ->get();
			$magz = DB::table('magazines')
            ->select('magazines.*')
            ->get();
			$otherz = DB::table('other_materials')
            ->select('other_materials.*')
            ->get();
			  // dd($purchased,$all_requests_this_sem, $bookz, $magz, $otherz);
		
		$subjects = RequestEndorsement::join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																 ->select('request_endorsements.*','requests.*')->get();
																
		$checker = 0.00;
		
		// dd($purchased);

		$search = \Request::get('subject');

		$try = RequestEndorsement::with('request')->join('requests', 'requests.id', '=', 'request_endorsements.request_id')
																->select('request_endorsements.*','requests.*')->where('subject','like', '%'.$search.'%')
																->get(); //pagkuha sa mga nasa search bar hahaha.

			
			return view('purchasehistory.seeall',compact('user','departments','department','purchased','all','checker','search','try','subjects','bookz','magz','otherz'));
	
	}
	
	
}
