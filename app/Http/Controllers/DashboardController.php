<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Auth;

use App\Aysem;
use App\Department;
use App\AccountTransactions;
use Illuminate\Support\Facades\DB;


class DashboardController extends Controller
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
        if(is_null($user) || is_null($user->department_id)){abort(404);}



        $records_to_fetch = 100;
        $department = Department::find($user->department_id);
        $current_aysem = Aysem::current();

        //balance history
        $balance_history = AccountTransactions::where('department_id',$department->id)->orderBy('id','created_at')->take($records_to_fetch)->get();

        $aysem_summary = [];
        $loopsem = Aysem::current();
        for ($i=0; $i < 6 && !is_null($loopsem); $i++) { 
           
            $aysem_summary[$loopsem->aysem] = AccountTransactions::aysemSummary($department,$loopsem);
            $loopsem = $loopsem->previous();
        }
       
        


       
        $balance_chart = [];

        foreach($balance_history as $key => $history) {
            if(!isset($balance_chart[$history->aysem] )){
                $balance_chart[$history->aysem] =[];
            }

            if(!isset($balance_chart[$history->aysem]['income'] )){
                $balance_chart[$history->aysem]['income']  = 0;
            }

            if(!isset($balance_chart[$history->aysem]['expenses'] )){
                $balance_chart[$history->aysem]['expenses']  = 0;
            }

            if( $history->transaction_type_id == 'C' ){
                $balance_chart[$history->aysem]['income'] += $history->amount;
            }else{
                $balance_chart[$history->aysem]['expenses'] += $history->amount;
            }
            $balance_chart[$history->aysem]['balance'] = $history->balance;
        }

        // dd($balance_chart);

        // dd($balance_historyistory->toArray());
        //total collections
        

        $summary_of_expenses = $this->summaryOfExpenses();


        
        return view('dashboard.dashboard',compact('user','department', 'balance_history','balance_chart' ,'aysem_summary'));
    }

    public function balancehistory()
    {
        
        return view('balance');
    }

    public function summaryOfExpenses(){

        $user = Auth::user();
        if(is_null($user) || is_null($user->department_id)){abort(404);}



        $records_to_fetch = 100;
        $department = Department::find($user->department_id);
        $current_aysem = Aysem::current();
    }
}
