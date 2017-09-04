<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Aysem;
use App\Account;
use App\Department;
use Illuminate\Support\Facades\DB;

class SemesterManagementController extends Controller
{
    public function index(Request $request)
    {

    	$user = Auth::user(); //fetch credentials

        if(is_null($user)){ //if not logged in
			return redirect('');			
		}
		elseif(Auth::user()->isLibrarian()){ //if user is librarian
			$active_department_id = $request->session()->get('active_dept_id',1) ; //get active dept else default is chem engg dept 
			$department = Department::find($active_department_id); 
		}
		else{ 
			$department = Department::find($user->department_id);
		}//end if

		$current_aysem = Aysem::current();
		$departments = Department::all();
		$existing_semesters = [$current_aysem['aysem']=>$current_aysem];

    	return view('semester_management.index',compact('active_department_id','departments','department', 'user','current_aysem', 'created_at','existing_semesters'));
    }

    public function create(Request $request){

    	//create new semester
    	$new_sem = Aysem::current();//fetch current sem, create new aysem object
		$new_sem = $new_sem['aysem'];//fetch aysem attribute
		
		if($new_sem%10 == 3){ //if midyear, new academic year
			$new_sem = $new_sem+8;
		}else{ //else just add sem
			$new_sem = $new_sem+1;
		}//end if

		$new_sem = [ 'aysem' => $new_sem, 'short_name' => Aysem::shortName($new_sem) , 'full_name' =>  Aysem::fullName($new_sem) ];
       	Aysem::create( $new_sem);
        $new_sem = Aysem::current();

       //create new account per department
        $prev_sem = $new_sem->previous(); 

        $deptids = Department::pluck('id')->toArray();
        
        foreach($deptids as $i){
        	$accnt=Account::where('department_id',$i)->get()->where('aysem',$prev_sem['aysem']); //get account of department id from previous semester

    	
            $new_account = ['department_id'=>$i,'aysem'=>$new_sem['aysem'],'begining_balance'=>$accnt[0]->currentBalance(),'ending_balance'=>0];
            //0 is default value for ending balance of newly created account
            Account::create($new_account);
        }//end for
    	return redirect('semestermanagement');
    }	
}
