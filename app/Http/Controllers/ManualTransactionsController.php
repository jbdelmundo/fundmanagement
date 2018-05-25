<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Aysem;
use App\Department;
use App\AccountTransactions;

class ManualTransactionsController extends Controller
{
    //
    function index(){
        $aysems = Aysem::all();
        $departments = Department::all();

        return view('manual_transactions.index',compact('aysems', 'departments'));
    }

    function add(Request $request){
        return $this->add_Account_Transaction($request, 1.0);
    }

    function deduct(Request $request){
        return $this->add_Account_Transaction($request, -1.0);
    }

    function add_Account_Transaction(Request $request, $amount_sign){
       
        // Insert validation for user?? or middleware is enough?

        $validation_rules = ['amount'=>"required|min:0|numeric", "remarks"=>"required"];
        $this->validate($request,$validation_rules);

        $amount = $request->amount * $amount_sign;

        $department = Department::find($request->department);                        
        $last_account_transaction = $department->last_account_transaction();

        $transaction = [];
        $transaction['department_id'] = $request->department; 
        $transaction['amount'] = $amount; 
        $transaction['balance'] = $last_account_transaction->balance + $amount;
        $transaction['aysem'] = $request->aysem;
        $transaction['transaction_type_id'] = 'M';
        $transaction['remarks'] = $request->remarks;
        $transaction['parent_account_transaction_id'] = $last_account_transaction->id;
        
        $account_transactions = \App\AccountTransactions::create($transaction);     
        $account_transactions->save();

        if($amount_sign >0){
            session()->flash('alert-success', 
                $department->short_name . ' received amount of ' . $request->amount . ' for '
                . Aysem::where('aysem',$request->aysem)->first()->short_name . '.'
            );
        }else{
            session()->flash('alert-success', 
               $department->short_name . ' is deducted with the amount of ' . $request->amount . ' for '
                . Aysem::where('aysem',$request->aysem)->first()->short_name . '.'
                );
        }
        

        return redirect('manual_transactions');
    }
}
