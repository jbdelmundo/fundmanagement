<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestEndorsement extends Model
{
    //

    protected $fillable = [
    	'request_id',
    	'quantity',
    	'subject',
    	'is_reserved',
    	'pr_number',
    	'status',
    	'endorsed_by',
    	'approved_by'

    ];

    function request(){
        return $this->belongsTo('\App\Requests');
    }
}
