<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Requests;

class Book extends Model
{
    //
    protected $fillable = ['title','request_id','author','edition','copyright_date','publisher','isbn','iselectronic'];

    function request(){
    	return Requests::where('item_id',$this->id)->where('category_id', Requests::BOOK)->first();
    }
}
