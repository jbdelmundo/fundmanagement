<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Requests;
use App\Aysem;
use App\Account;
use App\Department;
use App\Eresource;

class UsageStatisticsController extends Controller
{
    public function encode(Request $request)
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

		//get list of all purchased e resources
		$eresources=Requests::where('department_id',$active_department_id)->get()->where('category_id','E')->where('status',4);	//get array of all purchased e resources
		
		$all_eresources = Eresource::all();

		$list = array();//make final list array

		foreach($eresources as $eresc_find){
			foreach($all_eresources as $eresc){
				if($eresc_find['id']==$eresc['request_id']){
					$list[]=$eresc; //place eresource object into list array
					//$new_account = ['department_id'=>$i,'aysem'=>$new_sem['aysem'],'begining_balance'=>$accnt[0]->currentBalance(),'ending_balance'=>0];
        			//Account::create($new_account);
				}//end if
			}//end for
		}//end for
    	return view('usagestatistics.encode',compact('list','department'));
    }//end function

    public function gotoform(Request $request,$id)
    {
    	
    	$eresource = Eresource::Find($id);
    	return view('usagestatistics.form',compact('eresource'));
    }//end function

}//end class
