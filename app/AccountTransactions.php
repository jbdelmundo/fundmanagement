<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountTransactions extends Model
{
    //
    protected $fillable = [
      'aysem','department_id','account_id','request_id','collection_id','transaction_type_id', 'amount', 'balance', 'remarks', 
      'transaction_details_id','parent_account_transaction_id'];


    /****  RELATIONSHIP FUNCTIONS  ****/

    function department(){
        return $this->belongsTo('App\Department');
    }

    function request(){
        return $this->belongsTo('App\Requests');
    }
    

    
    

    static function ADJUSTMENT(){
    	return  DB::table('transaction_types')->where('transaction_type','ADJUSTMENT')->pluck('id')->first();
    }
    static function COLLECTION(){
    	return  DB::table('transaction_types')->where('transaction_type','COLLECTION')->pluck('id')->first();
    }
    static function PURCHASE(){
    	return  DB::table('transaction_types')->where('transaction_type','PURCHASE')->pluck('id')->first();
    }
    static function REFUND(){
    	return  DB::table('transaction_types')->where('transaction_type','REFUND')->pluck('id')->first();
    }
}
