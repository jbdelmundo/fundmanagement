<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RequestStatusesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {	
    	$statuses = [
    		[
    			'id' => 0,
    			'status' => 'RECORDED',
    			'description' => 'The system received the request. Awaiting for endorsement of LFC member.'
    		],
    		[
    			'id' => 1,
    			'status' => 'ENDORSED',
    			'description' => 'Endorsed by LFC member. Awaiting approval of department/institue head.'
    		],
    		[
    			'id' => 2,
    			'status' => 'APPROVED',
    			'description' => 'Approved by department/institue head. Awaiting for acquistion librarian to prepare purchase documents.'
    		],
    		[
                'id' => 3,
                'status' => 'FOR PURCHASE',
                'description' => 'Credited to account.'
            ],
            [
                'id' => 4,
                'status' => 'PURCHASED',
                'description' => 'Awaitng delivery.'
            ],
            [
                'id' => 5,
                'status' => 'DELIVERED',
                'description' => 'Delivered'
            ],
            [
                'id' => 6,
                'status' => 'REFUNDED',
                'description' => 'Refund from purchases. Debited to account.'
            ],
    	];
        DB::table('request_statuses')->insert($statuses);
    }
}
