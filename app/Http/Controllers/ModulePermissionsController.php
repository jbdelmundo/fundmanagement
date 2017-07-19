<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use Mail;

use App\Module;
use App\ModuleUser;

class ModulePermissionsController extends Controller
{
    //
	
	function index(){

		$modules = Module::all();
		$selected_modules = ModuleUser::where('user_id',1)->get()->toArray();
		
		foreach($selected_modules as $key => $value){
			$selected_modules[$key] = $value['module_id'];
		}
		foreach($modules as $key => $value){
			if(in_array($value->id,$selected_modules)){
				$value->selected = 1;
				$modules[$key] = $value;
			}
			else{
				$value->selected = 0;
				$modules[$key] = $value;
			}
		}
		
    	return view('module_permissions.index',compact('modules'));
    }
	
	function switch_active_user($user_id,Request $request){
		
		$modules = Module::all();
		$selected_modules = ModuleUser::where('user_id',$user_id)->get()->toArray();
		
			foreach($selected_modules as $key => $value){
				$selected_modules[$key] = $value['module_id'];
			}
			foreach($modules as $key => $value){
				if(in_array($value->id,$selected_modules)){
					$value->selected = 1;
					$modules[$key] = $value;
				}
				else{
					$value->selected = 0;
					$modules[$key] = $value;
				}
			}
		
    	$request->session()->put('modules',$modules);
    	$request->session()->put('active_user_id',$user_id);
    	return redirect()->back();
    }

	function create(Request $formrequest){
        
		$request = $formrequest	->toArray();
		$user_id = (int)$request['user_id'];
		
		$module_users = ModuleUser::where('user_id',$user_id);
		$module_users->delete();
		
		$count = 0;
		$module_permission = [];
		foreach($request as $key => $value){
			if($key != '_token' && $key != 'user_id'){
				$module_permission[$count]['module_id'] = $key;
				$module_permission[$count]['user_id'] = $user_id;
				$count++;
			}
		}
		foreach($module_permission as $key => $module){
			$module_user = ModuleUser::create($module);
			$module_user->save();
		}
		
		$request_description = [];
		foreach($module_permission as $key => $module){
			$request_description[$key+1] = Module::find($module['module_id'])->module;
		}
		
		$user = \App\User::find($user_id);
		
		$message = 'Library Fund Management System account '.Auth::user()->username .' updated the permitted modules for your account '. $user->username .'. Listed below are your current modules:';
		$user->message = $message;
		$user->request = $request_description;
		if($user->email){
			Mail::send('reminder', ['user' => $user], function ($m) use ($user) {
				$m->to($user->email)->subject('Module Permissions');
			});
        }
        return redirect('module_permissions/'.$user_id);
    }
}
