<?php

namespace App;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Model;
use App\Aysem;

class Account extends Model
{
    //database columns that can be modified
    protected $fillable = ['department_id','aysem','begining_balance','ending_balance'];


    /****  RELATIONSHIP FUNCTIONS  ****/

    function department(){
    	return $this->belongsTo('App\Department');
    }

    function transactions(){
    	return $this->hasMany('App\AccountTransactions');
    }

    function aysem(){
        return $this->belongsTo('App\Aysem','aysem','aysem');
    }


    /*****  UTILITY FUNCTIONS *****/

    function currentBalance(){

        $transactions = DB::table('account_transactions')
                ->where('account_id',$this->id)               
                ->sum('amount');

        return $transactions + $this->begining_balance;

    }
}
