<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

// use App\Http\Requests;
use App\Aysem;
use App\Department;
use App\Requests;


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

        if(!$user->isLibrarian()){
             return redirect()->action('HomeController@index');
        }
        
        //get active_dept from session, use department_id = 1 as default
        $department_id = $request->session()->get('active_dept_id',$user->id ) ;     
        $department = Department::find($department_id);

        $aysem = Aysem::current();

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

       
        
        $forms = $this->getForms();
        $active_form = 'Books';         //match with btn_caption


        $departments = Department::all();
        return view('requests.show', compact('user','departments','department','aysem','forms','active_form', 'requests_this_sem'
            ));
    }



    private function getForms(){
        // $categories = Requests::categories();
        // $forms = [];

        // foreach($categories as $id => $category){
        //     if($id == 'E' || $id == 'S'|| $id == 'O'){              //equipment, suppies or others
        //         $path = '_other_material_form';
        //     }else{
        //         $path = '_'.$category.'_form';
        //     }
            
        //     $forms[] =
        //             [
        //                 'btn_caption' => ucwords($category),
        //                 'form_id' => $category.'_form',
        //                 'form_title' => 'Request '.$category,
        //                 'form_path' => '_'.$category.'_form',
        //                 'category_id' => $id
        //             ];
        // }

        // TODO: FIX THIS ^^^ and THIS VVVV


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

        return redirect()->action('RequestsController@index' )->with('success', 'Request recorded!');
    }
}
