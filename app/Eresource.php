<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Eresource extends Model
{
    //
    protected $fillable = ['title','publisher','issubscription','startdate','enddate','request_id'];
    function UsageStatistics(){
    	return $this->hasMany('App\UsageStatistics');
    }
}
