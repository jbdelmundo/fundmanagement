<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\AccountTransactions;
use App\Aysem;

use Illuminate\Support\Facades\DB;

class Department extends Model
{
    //
    protected $fillable = ['initials','short_name','full_name','percent_allocation'];

    function account_transactions(){
    	return $this->hasMany(AccountTransactions);
    }

    function balance(){
    	$result =  DB::table('account_transactions')
    			->where( [ 'department_id'=>$this->id] )
				->orderBy('created_at')
				->take(1)
				->pluck('amount')->first();

		
		if(count($result) == 0){	
			return 0.0;
		}else{
			return $result;
		}
    }

    function requestsForSem(Aysem $aysem){
    	$reqs = Requests::where(['department_id'=>$this->id, 'aysem'=>$aysem->aysem])->get();
    	return $reqs;
    }

    function bookRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::BOOK)
    				->join('books', 'requests.item_id','=','books.id')
    				->get();

    	return $reqs;
    }

    function ebookRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::EBOOK)
    				->join('books', 'requests.item_id','=','books.id')
    				->get();

    	return $reqs;
    }

    function journalRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::JOURNAL)
    				->join('magazines', 'requests.item_id','=','magazines.id')
    				->get();

    	return $reqs;
    }

    function magazineRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::MAGAZINE)
    				->join('magazines', 'requests.item_id','=','magazines.id')
    				->get();

    	return $reqs;
    }

    function eresourceRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::ERESOURCE)
    				->join('eresources', 'requests.item_id','=','eresources.id')
    				->get();

    	return $reqs;
    }

    function suppliesRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::SUPPLIES)
    				->join('other_materials', 'requests.item_id','=','other_materials.id')
    				->get();

    	return $reqs;
    }

    function equipmentRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::EQUIPMENT)
    				->join('other_materials', 'requests.item_id','=','other_materials.id')
    				->get();

    	return $reqs;
    }

    function otherRequestsForSem(Aysem $aysem){
    	$reqs = DB::table('requests')
    				->where('department_id',$this->id)
    				->where('aysem',$aysem->aysem)
    				->where('category_id',Requests::OTHER)
    				->join('other_materials', 'requests.item_id','=','other_materials.id')
    				->get();

    	return $reqs;
    }
}
