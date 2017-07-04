<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\EnrolleeStatistics;

use App\Department;
use App\Aysem;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
    //
    protected $fillable = ['aysem','amount'];



  	/****  RELATIONSHIP FUNCTIONS  ****/

  	function collections(){
    	return $this->hasMany(Aysem,'aysem','aysem')
    		->orderBy('created_at', 'desc');
    }

    function enrolleeStatistics(){
    	return $this->hasMany('App\EnrolleeStatistics')
    		->orderBy('created_at', 'desc');
    }

    
    function scopeLatest($query,$aysem){
    	return $query->where('aysem', '=', $aysem)->orderBy('created_at', 'desc')->first();
    }

    


    static function isFirstCollectionForTheSem(Aysem $aysem){
    	return count(Collection::where('aysem',$aysem->aysem)->get()) == 0;
	}

}
