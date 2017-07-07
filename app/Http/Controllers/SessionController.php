<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SessionController extends Controller
{
    //

    function switch_active_dept($dept_id,Request $request){
    	$request->session()->put('active_dept_id',$dept_id);
    	return redirect()->back();
    }


}
