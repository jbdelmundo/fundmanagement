<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Aysem;
use App\Department;
use App\Requests;
use App\RequestEndorsement;

use Mail;
use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;

class RequestEndorsementController extends Controller
{
    //

    function index(Request $request){

    	$user = Auth::user();

        if($user->isLibrarian()){
           $department_id = $request->session()->get('active_dept_id',1 ) ;    
        }else{
            $department_id = $user->department->id;
        }
        $department = Department::find($department_id);
        $dept = $department; 
        
        $aysem = $request->session()->get('active_aysem', Aysem::current()->aysem );
        $aysem = Aysem::where('aysem',$aysem)->first();

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



        $requests_this_sem = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $requests_this_sem[$key] = $value->where('status',Requests::RECORDED);   //filter only those who is not yet processed
        }

        $endorsements = [];
        foreach ($all_requests_this_sem as $key => $value) {
            $endorsements[$key] = $value->where('status',Requests::ENDORSED);   //filter only those that are endorsed
        }
    	return view('request_endorsement.index',compact('user','departments','department','aysem', 'requests_this_sem','endorsements'
            ));
    }

    function create(Request $formrequest){
        

        $request = Requests::findOrFail($formrequest->request_id);
        
        $category = $request->category_id;
        

        switch ($category) {
            case Requests::BOOK:
                
                $validation_rules = ['subject'=>'required' , 'quantity'=>'required|min:1'];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray());                           

                break;

            case Requests::EBOOK:

                $validation_rules = ['subject'=>'required','quantity'=>'required|min:1' ];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray());                           

                break;

            // case Requests::EQUIPMENT:
            // case Requests::SUPPLIES:
            // case Requests::OTHER:
            default:
                
                $validation_rules = ['quantity'=>'required|min:1'];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray()); 
                # code...
                break;
        }

		
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
				
				$message = 'A new '.$category_name.' endorsement was made by the Library Fund Management System account '.Auth::user()->username.' for the '.\App\Department::find($request->department_id)->full_name.'.';
				$user['message'] = $message;
				$user['request'] = ['Title/Descrition' => $item,
									'Date Requested' => $request->created_at->format('d-M-Y'),
									'Recommended By' => $request->recommendedby];
				if($user['email']){
					Mail::send('reminder', ['user' => $user], function ($m) use ($user) {
						$m->to($user['email'])->subject('New Endorsement');
					});
				}
			}
			
        $request_endorsement->endorsed_by = Auth::user()->id; 
        $request_endorsement->save();  

        //update the status to endorsed
        $request->status = Requests::ENDORSED;
        $request->total_quote_price = $formrequest->quantity * $request->unit_quote_price;
        $request->save();

        session()->flash('alert-success', 'Request endorsed and waiting for approval!');
        return redirect('endorsement');
    }
	
	function remove($request_id){
		
		
        //update the status to endorsed
		$request = Requests::find($request_id);
        $request->status = Requests::RECORDED;
        $request->total_quote_price = 0;
        $request->save();
		
		$endorsement = RequestEndorsement::where('request_id', $request_id)->delete();
		return redirect(url('endorsement'));
	}
}
