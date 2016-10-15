<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aysem extends Model
{
    //
    protected $fillable = ['aysem','short_name','full_name'];

    public static function abbrev($aysem){
        $name = '';
        $aysem = intval($aysem);
        $sem = $aysem%10;
        $year = intval($aysem/10) ;

        if($sem == '1'){
            $name .= '1st ';
        }elseif($sem == '2'){
            $name .= '2nd ';
        }else{
            $name .= 'Mid ';
        }

        $name = $name . ' ' . intval($year%100)  . '-' .intval(($year+1)%100);
        return $name;
    }

    public static function shortName($aysem=20162){
    	$name = '';
        $aysem = intval($aysem);
    	$sem = $aysem%10;
    	$year = intval($aysem/10) ;

    	if($sem == '1'){
    		$name .= '1st Sem ';
    	}elseif($sem == '2'){
    		$name .= '2nd Sem ';
    	}else{
    		$name .= 'Midsem ';
    	}

    	$name = $name . ' ' . $year  . '-' .($year+1);
    	return $name;
    }

    public static function fullName($aysem){
    	$name = '';

    	$sem = $aysem%10;
        $year = $aysem/10 ;

    	if($sem == '1'){
    		$name .= '1st Semester AY';
    	}elseif($sem == '2'){
    		$name .= '2nd Semester AY';
    	}else{
    		$name .= 'Mid Semester AY';
    	}

    	$name .= ' ' . $year + '-' .($year+1);
    	return $name;
    }

    public static function current(){
        return Aysem::where('aysem',20161)->first();
    }

    public function getShortName(){
        return $this->shortName($this->aysem);
    }

    public function getFullName(){
        return $this->fullName($this->aysem);
    }

   

}
