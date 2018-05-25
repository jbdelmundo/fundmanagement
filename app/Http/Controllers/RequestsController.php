<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Aysem;
use App\Department;
use App\Requests;

use Mail;
use App\Book;
use App\Magazine;
use App\Eresource;
use App\OtherMaterial;

use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    //
    
    

    function index(Request $request){
        $user = Auth::user(); 

        if($user->isLibrarian()){ 
            //get active_dept from session, use department_id = 1 as default
            $department_id = $request->session()->get('active_dept_id',1) ;
        }else{
            $department_id = $user->department->id;
        }     
        $department = Department::find($department_id);

        $aysem_id = $request->session()->get('active_aysem',Aysem::current()->aysem);
        $aysem = Aysem::where('aysem',$aysem_id)->first();


        $requests_this_sem = [
            Requests::BOOK =>   $department->bookRequestsForSem($aysem),
            Requests::EBOOK =>   $department->ebookRequestsForSem($aysem),
            Requests::JOURNAL =>   $department->journalRequestsForSem($aysem),
            Requests::MAGAZINE =>   $department->magazineRequestsForSem($aysem),
            Requests::ERESOURCE =>   $department->eresourceRequestsForSem($aysem),
            Requests::SUPPLIES =>   $department->suppliesRequestsForSem($aysem),
            Requests::EQUIPMENT =>   $department->equipmentRequestsForSem($aysem),
            Requests::OTHER =>   $department->otherRequestsForSem($aysem)
        ];

        $request_count = Requests::where('department_id',$department_id)->where('aysem',$aysem_id)->count();
        
        
        $forms = $this->getForms();
        $active_form = 'Books';         //match with btn_caption


        $departments = Department::all();
        $aysems = Aysem::all();
        return view('requests.show', compact('request_count','user','departments','department','aysem','forms','active_form', 'requests_this_sem','aysems'
            ));
    }



    private function getForms(){
     
        $forms = [
                    [
                        'btn_caption' => 'Books',
                        'form_id' => 'book_form',
                        'form_title' => 'Request book',
                        'form_path' => '_book_form',
                        'category_id' => 'B'
                    ],
                    [
                        'btn_caption' => 'E-books',
                        'form_id' => 'ebook_form',
                        'form_title' => 'Request E-book',
                        'form_path' => '_ebook_form',
                        'category_id' => 'E'
                    ],
                    [
                        'btn_caption' => 'E-Journal',
                        'form_id' => 'ejournal_form',
                        'form_title' => 'Request E-Journal',
                        'form_path' => '_ejournal_form',
                        'category_id' => 'J'
                    ],
                    [
                        'btn_caption' => 'Magazines',
                        'form_id' => 'magazine_form',
                        'form_title' => 'Request magazine',
                        'form_path' => '_magazine_form',
                        'category_id' => 'M'
                    ],
                    [
                        'btn_caption' => 'E-Resource',
                        'form_id' => 'eresource_form',
                        'form_title' => 'Request an electronic resource',
                        'form_path' => '_eresource_form',
                        'category_id' => 'R'
                    ],
                     [
                        'btn_caption' => 'Equipment',
                        'form_id' => 'equipment_form',
                        'form_title' => 'Request Equipment',
                        'form_path' => '_other_material_form',
                        'category_id' => 'Q'
                    ],
                     [
                        'btn_caption' => 'Supplies',
                        'form_id' => 'supplies_form',
                        'form_title' => 'Request supplies',
                        'form_path' => '_other_material_form',
                        'category_id' => 'S'
                    ],
                    [
                        'btn_caption' => 'Others',
                        'form_id' => 'other_material_form',
                        'form_title' => 'Request generic material',
                        'form_path' => '_other_material_form',
                        'category_id' => 'O'
                    ]
                ];
                return $forms;                               
    }


    function create(Request $request){
        // dd($request);
        if($request->category_id == Requests::ERESOURCE && $request->issubscription == 1){
            $validation_rules = ['startdate'=>'required','enddate'=>'required|after:startdate'];
            $this->validate($request,$validation_rules);
        }

		$request_description = [];
		foreach($request->all() as $key => $value){
			if($key == 'description'){
				$request_description['Description'] = $value;
			}
			else if($key == 'category_id'){
				if($value == 'B')	$request_description['Category'] = 'Books';
				else if($value == 'E')	$request_description['Category'] = 'eBooks';
				else if($value == 'J')	$request_description['Category'] = 'Journals';
				else if($value == 'M')	$request_description['Category'] = 'Magazines';
				else if($value == 'R')	$request_description['Category'] = 'eResources';
				else if($value == 'Q')	$request_description['Category'] = 'Equipment';
				else if($value == 'S')	$request_description['Category'] = 'Supplies';
				else if($value == 'O')	$request_description['Category'] = 'Other Materials';
			}
			else if($key == 'unit_quote_price'){
				$request_description['Unit Quote Price'] = $value;
			}
			else if($key == 'remarks'){
				$request_description['Remarks'] = $value;
			}
			else if($key == 'title'){
				$request_description['Title'] = $value;
			}
			else if($key == 'author'){
				$request_description['Author'] = $value;
			}
			else if($key == 'publisher'){
				$request_description['Publisher'] = $value;
			}
			else if($key == 'year'){
				$request_description['Year'] = $value;
			}
			else if($key == 'edition'){
				$request_description['Edition'] = $value;
			}
			else if($key == 'copyright_date'){
				$request_description['Copyright Date'] = $value;
			}
			else if($key == 'publisher'){
				$request_description['Publisher'] = $value;
			}
			else if($key == 'recommendedby'){
				$request_description['Recommended By'] = $value;
			}
		}
		
		$users = \App\User::where('department_id',$request->department_id)->get()->toArray();
		
		foreach($users as $user){
			
			$message = 'New Request from the Library Fund Management System account '. Auth::user()->username .' for the '.\App\Department::find($request->department_id)->full_name.'.';
			$user['message'] = $message;
			$user['request'] = $request_description;
			if($user['email']){
				Mail::send('reminder', ['user' => $user], function ($m) use ($user) {
					$m->to($user['email'])->subject('New Request');
				});
			}
		}
		       
        // $request->is_reserved = isset($request->is_reserved); 
        // dd($request);
        // abort(403,'Record not found');

        $department_id = $request->session()->get('active_dept_id',0 ) ;     
        $department = Department::find($department_id);

        $aysem = Aysem::current();

        

        $categories = Requests::categories();
        $category_id = $request->category_id;

        //TODO: add validation 


        //insert into requests
        //insert into individual tables
        
        $params = $request->all();
        $params['total_quote_price'] = 0;
        $params['total_bid_price'] = 0;
        // dd($params);
        $request_obj = Requests::create($params);
        $params['request_id'] = $request_obj->id;

        

        switch($category_id){

            case 'B':   //Books
            case 'E':   //Ebooks
                $item = Book::create($params);
                break;

            case 'J':   //journal
            case 'M':   //magazine
                $item = Magazine::create($params);
                break;


            case 'R':   //resource
                $item = Eresource::create($params);
                break;

            case 'Q':   //equipment
            case 'S':   //supplies
            case 'O':   //other
                $item = OtherMaterial::create($params);
                break;
        }
        
        $request_obj->item_id = $item->id;
        $request_obj->save();

        session()->flash('alert-success', 'Request recorded!');
        return redirect()->action('RequestsController@index' )->with('success', 'Request recorded!');
    }

    public function delete($id){
         $request_objv
    }
}
