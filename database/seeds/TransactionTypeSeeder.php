<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TransactionTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$types = [
    		[
    			'id' => 'C',
    			'transaction_type' => 'COLLECTION',
    			'description' => 'Collection from main library'
    		],
    		[
    			'id' => 'P',
    			'transaction_type' => 'PURCHASE',
    			'description' => 'Deduction as a result of a purchase'
    		],
    		[
    			'id' => 'A',
    			'transaction_type' => 'ADJUSTMENT',
    			'description' => 'Collection adjustment caused by changes in enrollment and allocation'
    		],
    		[
    			'id' => 'R',
    			'transaction_type' => 'REFUND',
    			'description' => 'Refund from purchases'
    		],
            [
                'id' => 'I',
                'transaction_type' => 'INITIAL',
                'description' => 'Initial fund'
            ],
            [
                'id' => 'M',
                'transaction_type' => 'MANUAL',
                'description' => 'Manual transaction made'
            ],
    	];
        DB::table('transaction_types')->insert($types);
    }
}
