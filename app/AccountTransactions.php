<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountTransactions extends Model
{
    //
    protected $fillable = ['aysem','department_id','transaction_type_id', 'amount','balance' , 'remarks','transaction_details_id'];

    static function currentBalance($aysem,$department_id){
    	$result =  DB::table('account_transactions')
    			->where( [ 'department_id'=>$department_id] )
				->orderBy('id','desc')
				->take(1)
				->pluck('balance')
                ->first()
                ;

		
		if(count($result) == 0){	
			return 0.0;
		}else{
			return $result;
		}
    }   //$val = App\AccountTransactions::currentBalance(20101,1)

    static function balanceHistory(Department $department){
        $balance_history = AccountTransactions::where('department_id',$department->id)
                            ->orderBy('id','desc')
                            ->pluck('balance','aysem')
                            ->get();
        return $balance_history;
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
