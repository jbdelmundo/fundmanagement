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
use App\UsageStatistics;


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
					
				}//end if
			}//end for
		}//end for
    	return view('usagestatistics.encode',compact('list','department'));
    }//end function

    public function gotoform(Request $request,$id)
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

    	$eresource = Eresource::Find($id);
    	return view('usagestatistics.form',compact('eresource'));
    }//end function

    public function submitform(Request $request,$id){
        $stats = $request->all();
        $stats_temp=array_slice($stats,1); //returns usage stats per month
        $stats=array();
        foreach($stats_temp as $stat){
        	$stats[]=$stat;
        }//end for

        $eresource = Eresource::Find($id);
        $eresource_request = Requests::Find($eresource['request_id']);
        
        $year_arr = session('year_arr');
        $month_arr = session('month_arr');
        $f_month = session('f_month');
        $diff = session('diff');
        $y_diff = session('y_diff');

        $month_ctr = $f_month;
        $j=0; 

		for($i=0;$i<=$y_diff;$i++){
				  
			$current_year = $year_arr[$i];


			while($diff>=0){

				if($month_ctr==12){
					$month_ctr=0;
					break;
				}//end if

       			$new_entry = ['eresource_id'=>$eresource['id'],'request_id'=>$eresource['request_id'],'department_id'=>$eresource_request['department_id'],'status_id'=>4,'month'=>$month_ctr,'year'=>$current_year,'usage'=>$stats[$j]];
				
       			//UsageStatistics::create($new_entry);

				$diff = $diff-1;
				$month_ctr=$month_ctr+1;
				$j=$j+1;
			}//end while		
		}//end for		

    	return view('usagestatistics.index');
    }//end function

}//end class
