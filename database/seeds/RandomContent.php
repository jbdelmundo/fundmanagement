<?php

use Illuminate\Database\Seeder;

use App\Http\Requests;
use App\Aysem;
use App\Collection;
use App\Department;
use App\EnrolleeStatistics;
use App\AccountTransactions;
use Illuminate\Support\Facades\DB;

class RandomContent extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //allocations
        //requestbooks

    	$aysems = [];
        for($i=2010; $i <= 2016; $i++) { 

            for ($j=1; $j < 3; $j++) { 
            	$aysem = $i*10 +$j;

            	$this->allocate($aysem, rand(800000,1000000));
            	$this->purchase($aysem,3);
            }
        }

        // $this->allocate(20101,100000);
        // $this->allocate(20102,200000);
        // $this->allocate(20103,45000);
        // $this->allocate(20111,90000);
        // $this->allocate(20112,180000);
        // $this->allocate(20113,35000);
        // $this->allocate(20121,110000);
        // $this->allocate(20122,210000);
        // $this->allocate(20123,55000);

        // $this->purchase(20101,3);
        // $this->purchase(20102,3);
        // $this->purchase(20103,3);
        // $this->purchase(20111,3);
        // $this->purchase(20112,3);
    }


    function purchase($aysem,$times){
    	$aysem = Aysem::where('aysem','=',$aysem)->first();

    	for ($j=0; $j < $times; $j++) { 
	    	$deductions=[];

	    	for ($i=1; $i <=10 ; $i++) { 
	    		$deductions[$i] = rand(5000,15000);
	    	}
	    	
    		foreach($deductions as $dept_id => $deduction){
			
			$input = [
				'aysem' => $aysem->aysem,
				'department_id' => $dept_id,
				'transaction_type_id' => AccountTransactions::PURCHASE(),
				'amount' => $deduction,
				'balance' => floatval( AccountTransactions::currentBalance($aysem,Department::find($dept_id)) ) - floatval($deduction)

			];
		
			AccountTransactions::create($input);
        
			}

    	}
    	

    }

    function allocate($aysem, $amount){
    	
    	$aysem = Aysem::where('aysem','=',$aysem)->first();
    	$amount = $amount ;
    	$statistics = [];		//array statistics[deptid][undergraduate]

    	for ($i=1; $i <=10 ; $i++) { 
    		$statistics[$i] = [
    			'undergraduate' => rand(100,200),
    			'graduate' => rand(10,30)
    		];
    	}

    	$collection = Collection::create(['aysem'=>$aysem->aysem , 'amount' => $amount ]);
			

		//save enrollee statistics
		foreach($statistics as $department_id => $department){
			$input = [
				'aysem' => $collection->aysem,
				'collection_id' => $collection->id,
				'department_id' => $department_id,
				'undergraduate' => $department['undergraduate'],
				'graduate' => $department['graduate']
			];
			$dept_statistics = EnrolleeStatistics::create($input);
		}


		$allocations =  Collection::computeAllocations($amount,$statistics);
		$deb = [];
		foreach($allocations as $dept_id => $allocation){
			
			$input = [
				'aysem' => $aysem->aysem,
				'department_id' => $dept_id,
				'transaction_type_id' => AccountTransactions::COLLECTION(),
				'amount' => $allocation,
				'balance' => floatval( AccountTransactions::currentBalance($aysem,Department::find($dept_id) )) + floatval($allocation)

			];
		
			AccountTransactions::create($input);
		}
    }
}
