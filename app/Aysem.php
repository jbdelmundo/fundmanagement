<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Aysem extends Model
{
    //
    protected $fillable = ['aysem','short_name','full_name'];

    /*****  RELATIONSHIP FUNCTIONS *****/

    function collection(){
        return $this->hasMany('App\Collection');
    }


    /*****  UTILITY FUNCTIONS *****/

    public  function previous(){
        $aysem = intval($this->aysem);
        $sem = $aysem%10;
        $year = intval($aysem/10) ;

        if($sem != 1){
            $id = $year*10 + ($sem-1);
            return Aysem::where('aysem',$id)->first();
        }else{
            $id = ($year-1)*10 + 3;
            return Aysem::where('aysem',$id)->first();
        }
    }

    public function getShortName(){
        return $this->shortName($this->aysem);
    }

    public function getFullName(){
        return $this->fullName($this->aysem);
    }

    /****** STATIC FUNCTIONS ****/

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

    	if($sem == 1){
    		$name .= '1st Semester AY';
    	}elseif($sem == 2){
    		$name .= '2nd Semester AY';
    	}else{
    		$name .= 'Mid Semester AY';
    	}

    	$name .= ' ' . $year . '-' .intval($year+1);

    	return $name;
    }

    public static function current(){
        return Aysem::orderBy('aysem','desc')->first();
    }

    

   

}
