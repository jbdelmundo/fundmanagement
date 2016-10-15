<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    //
    const BOOK = 'B';
    const EBOOK = 'E';
    const MAGAZINE = 'M';
    const JOURNAL = 'J';
    const ERESOURCE = 'R';
    const EQUIPMENT = 'Q';
    const SUPPLIES = 'S';
    const OTHER = 'O';

    protected $fillable = ['aysem','department_id','unit_quote_price','quantity','reserve_quantity','remarks','recommendedby','category_id','item_id'];

    static function categories(){

    	$categories = [
    		'B' => 'books',
    		'E' => 'ebooks',
    		'M' => 'magazines',
    		'J' => 'journals',
    		'R' => 'eresources',
    		'Q' => 'equipment',
    		'S' => 'supplies',
    		'O' => 'other'

    	];
    	return $categories;
    }
}
