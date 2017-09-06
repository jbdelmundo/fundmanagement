<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Aysem;
use App\Department;
use App\AccountTransactions;
use App\Account;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\User;

class UserManagementController extends Controller
{

    
     public function __construct()
    {
        // $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
      
        $user = Auth::user();
      

        $selected_user_id = session()->get('active_user', $user->id);
        $current_user = User::findOrFail($selected_user_id); 
        
        $departments = Department::all();
        $roles = DB::table('user_roles')->get();
        // dd($selected_user_id);
        

       return view('usermanagement.usermanagement',compact('active_user_id','roles', 'departments', 'current_user'));
    }

    function store(Request $request){
        
        
        $update = User::findOrFail($request->selected_user);
        
        //validate
        if($request->username != $update->username){
            $validation_rules = ['username'=>"required|min:1|unique:users,username"];
        }else{
            $validation_rules = ['username'=>"required|min:1"];
        }
        $this->validate($request,$validation_rules);
        
        $update->username = $request->username;
        // $update->password = Hash::make($request->pw);
        $update->email = (trim($request->email) == '')? null : trim($request->email);
      
        $update->userrole_id = $request->role_selector;
        $update->department_id = $request->dept_selector;

        



        $update->save();

        session()->flash('alert-success','User info updated.');
        return redirect()->back();
   }

   function changepassword(Request $request){

        $validation_rules = ['password'=>"required",'confirm_password'=>'required|same:password'];
        $this->validate($request,$validation_rules);


        $update = User::findOrFail($request->selected_user);
        $update->password = Hash::make($request->password);
        $update->save();
        
        session()->flash('alert-success','Password updated.');
        return redirect()->back();
   }
}
