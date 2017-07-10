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
    public function index(Request $request)
    {
        
        $user = Auth::user();
        $active_user_id = $user->id;

        $selected_user_id = $request->session()->get('selected_user', $active_user_id);

        $all_users = DB::table('users')->get();
        $departments = Department::all();
        $roles = DB::table('user_roles')->get();
        $def_user = DB::table('users')->where('id', $selected_user_id)->first(); //this is a whole row from db...
       return view('usermanagement.usermanagement',compact('active_user_id','roles','all_users', 'departments', 'def_user', 'selected_user_id'));
    }

    function store(Request $request){
        //dd($request);
        $update = User::findOrFail($request->selected_user);
        dd($request->all());
        $update->username = $request->username;
        $update->password = $request->pw;
        $update->email = $request->email;
        $update->save();

        return redirect()->back();
   }
}
