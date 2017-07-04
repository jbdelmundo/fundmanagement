<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Aysem;
use App\Department;
use App\Requests;
use App\RequestEndorsement;


use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;

class RequestEndorsementController extends Controller
{
    //

    function index(Request $request){

    	$user = Auth::user();
<<<<<<< HEAD
        if(is_null($user)){
			return redirect('');			
		}
    	$aysem = Aysem::current();

        $dept = $user->department()->first();
        $department = $dept;

        if(!is_null($user->department_id) && $user->department_id != $dept->id){
            abort(403, 'Unauthorized to access to this department.');
=======

        if($user->isLibrarian()){
           $department_id = $request->session()->get('active_dept_id',1 ) ;    
        }else{
            $department_id = $user->department->id;
>>>>>>> 87472476d0bc914be975b7628cc2c534f00daf48
        }
        $department = Department::find($department_id);
        $dept = $department; 
        
        $aysem = Aysem::current();
        

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
                $validation_rules = ['subject'=>'required' , 'quantity'=>'required|min:1'];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray());                           

                break;
            
            default:
                
                $validation_rules = ['quantity'=>'required|min:1'];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray()); 
                # code...
                break;
        }

        $request_endorsement->endorsed_by = Auth::user()->id; 
        $request_endorsement->save();  

        //update the status to endorsed
        $request->status = Requests::ENDORSED;
        $request->total_quote_price = $formrequest->quantity * $request->unit_quote_price;
        $request->save();

        
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
