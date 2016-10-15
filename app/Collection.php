<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App\EnrolleeStatistics;

use App\Department;
use App\Aysem;
use Illuminate\Support\Facades\DB;

class Collection extends Model
{
    //
    protected $fillable = ['aysem','amount'];

    const UNDERGRAD_WEIGHT = 1;				//undergradate students has  1/3 multiplier
	const GRAD_WEIGHT = 2;					//graduate students has 2/3 multiplier
	const TOTAL_WEIGHT = 3;

  



    /***
    * 	Returns true if there are no collections found durin $aysem
    */
    static function isFirstCollection(Aysem $aysem){

    	return count(Collection::where('aysem',$aysem->aysem)->get()) == 0;
    }

    function scopeLatest($query,$aysem){
    	return $query->where('aysem', '=', $aysem)->orderBy('created_at', 'desc')->first();
    }

    function collections(){

    	return $this->hasMany(Aysem,'aysem','aysem')->orderBy('created_at', 'desc');
    }

    function enrolleeStatistics(){

    	return $this->hasMany('App\EnrolleeStatistics')->orderBy('created_at', 'desc');
    }


    /**
    	@parameter $statistics[dept_id][udnergraduate|graduate] = count
    	@return $allocation[dept_id] = amount 
    */
    static function computeAllocations($amount, $statistics){

    	//compute amount to allocate per dept
		$percent_reserved =  floatval( DB::table('departments')->sum('percent_allocation') ) / 100 ;
		$amount_reserved_to_percentage = $amount * $percent_reserved;
		$amount_reserved_to_divide = $amount * (1 - $percent_reserved);

		$total_weight = 0;
		$weights = [];
		$allocations = [];


		foreach($statistics as $department_id => $department){
			$total_weight +=  intval($department['undergraduate'])*self::UNDERGRAD_WEIGHT/self::TOTAL_WEIGHT;
			$total_weight +=  intval($department['graduate'])*self::GRAD_WEIGHT/self::TOTAL_WEIGHT;
			$weights[$department_id] = [
				'ug' => intval($department['undergraduate'])*self::UNDERGRAD_WEIGHT/self::TOTAL_WEIGHT,
				'g' =>  intval($department['graduate'])*self::GRAD_WEIGHT/self::TOTAL_WEIGHT
			];

		}

		foreach ($weights as $department_id => $weight) {
			$allocations[$department_id] = $amount_reserved_to_divide * ($weight['ug'] + $weight['g']) / $total_weight;
		}


		$dept_with_percentage_allocation = Department::whereNotNull('percent_allocation')->get();
		foreach($dept_with_percentage_allocation as $dept){
			if($dept->percent_allocation > 0){
				$allocations[$dept->id] = $amount * floatval($dept->percent_allocation)/100;
			}
			 
		}
			
		return $allocations;
    }
}
