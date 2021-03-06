<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Collections;

class EnrolleeStatistics extends Model
{
    //
	protected $fillable = ['aysem','department_id','collection_id','undergraduate','graduate'];

	/****  RELATIONSHIP FUNCTIONS  ****/

	function collections(){
		return $this->belongsTo('App\Collections');
	}
}
