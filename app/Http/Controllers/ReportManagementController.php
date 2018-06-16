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
        $last_three_sems = Aysem::orderBy('aysem','desc')->limit(3)->get();

        $sem_details = [];
        $expenses = [];
        $sem_details_labels = [
            'starting_balance','collections','purchases','refunds','manual','ending_balance'
        ];
        $expenses_items = [
            Requests::BOOK =>   'Books',
            Requests::EBOOK =>   'E-books',
            Requests::JOURNAL =>   'Journals',
            Requests::MAGAZINE =>   'Magazines',
            Requests::ERESOURCE =>   'E-Resources',
            Requests::SUPPLIES =>   'Supplies',
            Requests::EQUIPMENT =>   'Equipment',
            Requests::OTHER =>   'Others'
        ];

        foreach($last_three_sems as $sem){

            // echo($sem->short_name);
            $sem_details[$sem->aysem] = $this->get_data($sem->aysem, $department->id);
            $expenses[$sem->aysem] =  $this->get_expense_breakdown($sem->aysem, $department->id);
        }

        

        return view('report_management.index',compact('sem_details','expenses','last_three_sems','sem_details_labels',
                        'expenses_items','department'));
    }

    private function get_data($aysem,$department_id){

        //All collections and adjustments
        $collections = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->whereIn('transaction_type_id',['C','A'])
        ->sum('amount');


        //purchases
        $purchases = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','P')
        ->sum('amount') * -1;       // convert to positive

        //refunds
        $refunds = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','R')
        ->sum('amount');

        //Manual
        $manual = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)
        ->where('transaction_type_id','M')
        ->sum('amount');

        $first_transaction = AccountTransactions::where('aysem',$aysem)
        ->where('department_id',$department_id)->orderBy('parent_account_transaction_id','asc')
            ->first();
        // dd(is_null($first_transaction));
        if(is_null($first_transaction)){

            $department_obj = Department::find($department_id);
            $last_transaction = $department_obj->last_account_transaction();
            $first_transaction = $last_transaction;

            $ending_balance = AccountTransactions::where('department_id',$department_id)->orderBy('parent_account_transaction_id','desc')
                ->first()->balance;
        }else{
            $ending_balance = AccountTransactions::where('aysem',$aysem)
            ->where('department_id',$department_id)->orderBy('parent_account_transaction_id','desc')
                ->first()->balance;
            
        }

            $starting_balance = $first_transaction->balance - $first_transaction->amount;

        



        return compact('collections','purchases','refunds','manual','starting_balance','ending_balance');
    }

    private function get_expense_breakdown($aysem,$department_id){

        $requests_this_sem = [
            Requests::BOOK =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::BOOK),
            Requests::EBOOK =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::EBOOK),
            Requests::JOURNAL =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::JOURNAL),
            Requests::MAGAZINE =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::MAGAZINE),
            Requests::ERESOURCE =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::ERESOURCE),
            Requests::SUPPLIES =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::SUPPLIES),
            Requests::EQUIPMENT =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::EQUIPMENT),
            Requests::OTHER =>   $this->get_total_quote_price_by_category($aysem,$department_id, Requests::OTHER)
        ];

        return $requests_this_sem;
       
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
