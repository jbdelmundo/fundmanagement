<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

use App\Department;

class UsageStatistics extends Authenticatable
{
    use Notifiable;
    public $table = "usagestatistics";
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'eresource_id', 'request_id','department_id','month','year','usage'
    ];

    function eresource(){
        return $this->belongsTo('App\Eresource');
    }

}
