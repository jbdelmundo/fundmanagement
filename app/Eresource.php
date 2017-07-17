<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eresource extends Model
{
    //
    protected $fillable = ['request_id','title','publisher','issubscription','startdate','enddate','request_id'];
     function request(){
    	return Requests::where('item_id',$this->id)->where('category_id', Requests::ERESOURCE)->first();
    }


    function usagestatistics(){
        return $this->hasMany('App\UsageStatistics');
       
    }
}
