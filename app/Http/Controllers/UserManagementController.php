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

        $all_users = DB::table('users')->get();
        $departments = Department::all();
        $roles = DB::table('user_roles')->get();
        $def_user = DB::table('users')->where('id', $user->id)->first();
       return view('usermanagement.usermanagement',compact('roles','all_users', 'departments', 'def_user'));
    }

    function store(Request $request)
    {
        dd($request);
        return "You clicked the submit button!";
    }
}
