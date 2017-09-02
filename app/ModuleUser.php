<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModuleUser extends Model
{
    //
	public $timestamps = false;
	protected $fillable = [
    	'module_id',
    	'user_id'
    ];

    function module(){
        return $this->belongsTo('App\Module');
    }

    function user(){
        return $this->belongsTo('App\User');
    }
}
