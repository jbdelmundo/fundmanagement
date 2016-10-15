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
    function index(){

    	$user = Auth::user();



    	$user_dept = is_null($user)? null : $user->department_id;
    	$departments = Department::all();
    	$current_aysem = Aysem::current();

    	if(!$user->isLibrarian()){
             return redirect()->action('RequestsController@show',['dept'=>$user->id , 'aysem'=>$current_aysem->aysem]);
    	}



    	return view('requests.index', compact('department','current_aysem'));
    }


    /* Display form to create a new request*/
   

    function store(){

    }

    function show(Department $dept,Aysem $aysem){
        // abort(403,'Record not found');
        $user = Auth::user();
        $department = $dept;
        if(!is_null($user->department_id) && $user->department_id != $dept->id){
            abort(403, 'Unauthorized to access to this department.');
        }

        $requests_this_sem = [
            Requests::BOOK =>   $dept->bookRequestsForSem($aysem),
            Requests::EBOOK =>   $dept->ebookRequestsForSem($aysem),
            Requests::JOURNAL =>   $dept->journalRequestsForSem($aysem),
            Requests::MAGAZINE =>   $dept->magazineRequestsForSem($aysem),
            Requests::ERESOURCE =>   $dept->eresourceRequestsForSem($aysem),
            Requests::SUPPLIES =>   $dept->suppliesRequestsForSem($aysem),
            Requests::EQUIPMENT =>   $dept->equipmentRequestsForSem($aysem),
            Requests::OTHER =>   $dept->otherRequestsForSem($aysem)
        ];

       
        
        $forms = $this->getForms();
        $active_form = 'Books';         //match with btn_caption



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
                        'category_id' => 'E'
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
    function create(Department $dept,Aysem $aysem, Request $request){
        // abort(403,'Record not found');
        $categories = Requests::categories();
        $category_id = $request->category_id;

        //TODO: add validation 
        //TODO: aysem, dept comes from form

        switch($category_id){

            case 'B':
            case 'E':

                $item = Book::create($request->all());
                break;

            case 'J':
            case 'M':

                $item = Magazine::create($request->all());
                break;


            case 'R':

                $item = Eresource::create($request->all());
                break;

            case 'E':
            case 'S':
            case 'O':
                $item = OtherMaterial::create($request->all());
                break;

            //insert into requests

            //insert into individual tables

        }
        $params = $request->all();
        $params['item_id'] = $item->id;
        Requests::create($params);


        return redirect()->action('RequestsController@show',['dept'=>$dept->id , 'aysem'=>$aysem->aysem])->with('success', 'Collection recorded!');
    }
}
