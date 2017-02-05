<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Requests extends Model
{
    //
    const RECORDED = 0;                 //recorded and for approval of LFC
    const ENDORSED = 1;                 //for approval of chair
    const APPROVED = 2;                 //approved by chair, credited to balance, awaiting PR
    const FOR_PURCHASE = 3;             //PR issued
    const PURCHASED = 4;                //Awaiting delivery
    const DELIVERED = 5;


    const BOOK = 'B';
    const EBOOK = 'E';
    const MAGAZINE = 'M';
    const JOURNAL = 'J';
    const ERESOURCE = 'R';
    const EQUIPMENT = 'Q';
    const SUPPLIES = 'S';
    const OTHER = 'O';

    protected $fillable = ['aysem','department_id','unit_quote_price','remarks','recommendedby','category_id','item_id'];

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

    function requestEndorsement(){
        return $this->belongsTo('\App\RequestEndorsement','id','request_id');
    }


    function book(){
        
    }

    function ebook(){
        
    }

  
}
