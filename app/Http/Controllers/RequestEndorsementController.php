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

    function index(){

    	$user = Auth::user();
    	$aysem = Aysem::current();

        $dept = $user->department()->first(); //default lang
        $department = $dept;

        if(!is_null($user->department_id) && $user->department_id != $dept->id){
            abort(403, 'Unauthorized to access to this department.');
        }

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
                
                $validation_rules = ['subject'=>'required' ];
                $this->validate($formrequest,$validation_rules);
                $request_endorsement = \App\RequestEndorsement::create($formrequest->toArray());                           
                $request_endorsement->quantity = 1;                           

                break;
            
            default:
                # code...
                break;
        }

        $request_endorsement->endorsed_by = Auth::user()->id; 
        $request_endorsement->save();  

        //update the status to endorsed
        $request->status = Requests::ENDORSED;
        $request->save();

        
        return redirect('endorsement');
    }
}
