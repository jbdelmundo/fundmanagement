<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class AccountTransactions extends Model
{
    //
    protected $fillable = ['aysem','department_id','account_id','request_id','transaction_type_id', 'amount', 'remarks','transaction_details_id'];


    /****  RELATIONSHIP FUNCTIONS  ****/

    function account(){
        return $this->belongsTo('App\Account');
    }

    function request(){
        return $this->belongsTo('App\Requests');
    }
    
    /*****  UTILITY FUNCTIONS *****/

  //   static function currentBalance(Aysem $aysem,Department $department){
  //   	$result =  DB::table('account_transactions')
  //   			->where( [ 'department_id'=>$department->id ] )
  //               ->where('aysem', '<=',$aysem->aysem)
		// 		->orderBy('id','desc')
		// 		->take(1)
		// 		->pluck('balance')
  //               ->first()
  //               ;

  //       //get the starting balance of the sem,


		
		// if(count($result) == 0){	
           
		// 	return 0.0;
		// }else{
		// 	return $result;
		// }
  //   }   //$val = App\AccountTransactions::currentBalance(20101,1)

  //   static function balanceHistory(Department $department){
  //       $balance_history = AccountTransactions::where('department_id',$department->id)
  //                           ->orderBy('id','desc')
  //                           ->pluck('balance','aysem')
  //                           ->get();
  //       return $balance_history;
  //   }

  //   static function totalTransactions(Department $department ,Aysem $aysem ){


  //        $account_Summary = AccountTransactions::groupBy('aysem','department_id','transaction_type_id','transaction_type')
  //                                                   ->selectRaw('aysem,department_id,transaction_type_id,transaction_type, sum(amount) as amount')
  //                                                   ->join('transaction_types','transaction_type_id' , 'transaction_types.id')
  //                                                   ->having('department_id' , '=',$department->id)
  //                                                   ->having('aysem' , '=',$aysem->aysem)
  //                                                   ->orderBy('transaction_type_id')->get();

  //       return $account_Summary;
  //   }

  //   static function aysemSummary(Department $department ,Aysem $aysem ){
  //       $transaction_summary = AccountTransactions::totalTransactions($department,$aysem);
        

  //       $summary = [];
  //       foreach ($transaction_summary as $key => $transaction) {
  //           $summary[$transaction->transaction_type]  = $transaction->amount;
  //       }

  //       $types = [
  //           'COLLECTION', 'ADJUSTMENT','PURCHASE','REFUND'
  //       ];

  //       foreach ($types as $type) {
  //          if(!isset($summary[$type])){
  //               $summary[$type] = 0;
  //          }
  //       }



  //       $summary['BALANCE'] = AccountTransactions::currentBalance($aysem,$department );
  //       // dd($aysem);
  //       if(!is_null($aysem->previous())){
  //           $summary['PREV_BALANCE'] = AccountTransactions::currentBalance($aysem->previous(), $department );
  //       }else{
  //           $summary['PREV_BALANCE'] = 0;
  //       }


  //       return $summary;

  //   }



  //   static function summaryOfExpenses(Department $department ,Aysem $aysem ){
  //       DB::table('requests')->where('transaction_type','ADJUSTMENT')
  //                   ->selectRaw('aysem,department_id,transaction_type_id,transaction_type, sum(amount) as amount')
  //                   ->join('transaction_types','transaction_type_id' , 'transaction_types.id')
  //                   ->having('department_id' , '=',$department->id)
  //                   ->having('aysem' , '=',$aysem->aysem)
  //                   ->orderBy('transaction_type_id')->get();
  //   }

    

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
