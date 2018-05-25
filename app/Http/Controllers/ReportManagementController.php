<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountTransactions;
use Auth;
use App\Department;
use App\Aysem;
use App\Requests;


class ReportManagementController extends Controller
{
    //
    function index(Request $request){
        $user = Auth::user();
        if(is_null($user)){
            return redirect('');            
        }
        elseif(Auth::user()->isLibrarian()){
            $active_department_id = $request->session()->get('active_dept_id',1) ; 
            $department = Department::find($active_department_id);
            $departments = Department::all();           // For dropdown
        }
        else{
            $department = Department::find($user->department_id);
        }
        
        
        
        
        $current_aysem = $request->session()->get('active_aysem',Aysem::current()->aysem);
        $current_aysem = Aysem::where('aysem',$current_aysem)->first();
        $aysem = $current_aysem;


        //Balance from previous_sem
        //Get collection, adjustment for sem
        //Total Expense for sem
        //Refunds for sem
        //Ending Balance

        //Expenses
        //All purchased items for sem, group by type
        // Total expenses

        // Coverage: Last Three semesters
        return $this->get_expense_breakdown($aysem->aysem, $department->id);
    }

    private function get_data($aysem,$department_id){

        //All collections and adjustments
        $collections = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->whereIn('transaction_type_id',['C','A'])
        ->sum('amount');

        //Manual

        //purchases
        $purchases = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','P')
        ->sum('amount');

        //refunds
        $refunds = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','R')
        ->sum('amount');

        $manual = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','M')
        ->get();

        $first_transaction = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)->orderBy('parent_account_transaction_id','asc')
            ->first();

        $starting_balance = $first_transaction->balance - $first_transaction->amount;

        $ending_balance = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)->orderBy('parent_account_transaction_id','desc')
            ->first()->balance;


        echo $collections;
        echo '<hr>';
        echo $purchases;
        echo '<hr>';
        echo $refunds;
        echo '<hr>';
        echo $starting_balance;
        echo '<hr>';
        echo $ending_balance;
        // dd($purchases->toArray());
    }

    private function get_expense_breakdown($aysem,$department_id){

        $books = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::BOOK);
        $ebooks = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::EBOOK);
        $magazine = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::MAGAZINE);
        $journal = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::JOURNAL);
        $eresource = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::ERESOURCE);
        $equipment = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::EQUIPMENT);
        $supplies = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::SUPPLIES);
        $other = $this->get_total_quote_price_by_category($aysem,$department_id, Requests::OTHER);


        echo $books;
        echo '<hr>';
        echo $ebooks;
        echo '<hr>';
        echo $magazine;
        echo '<hr>';
        echo $journal;
        echo '<hr>';
        echo $eresource;
        echo '<hr>';
        echo $equipment;
        echo '<hr>';
        echo $supplies;
        echo '<hr>';
        echo $other;
        echo '<hr>';
       
    }

    private function get_total_quote_price_by_category($aysem,$department_id,$category_id){

        $result = Requests::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('category_id',$category_id)
        ->whereIn('status',[Requests::APPROVED, Requests::DISCOUNTED, Requests::REFUNDED])
        ->sum('total_quote_price');

        return $result;
    }
}
