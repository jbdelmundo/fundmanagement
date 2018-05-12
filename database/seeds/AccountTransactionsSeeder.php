<?php

use Illuminate\Database\Seeder;

class AccountTransactionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $all_depts = App\Department::all();
        foreach ($all_depts as $dept) {        	        	

        	$dept->account_transactions()->create([
        		'aysem' => App\Aysem::current()->aysem,
        		'department_id' => $dept->id,
                'transaction_type_id' => 'I',
                'amount' => 0,
                'balance' => 0,
                'remarks' => 'Inital balance'
    		]);


        }
    }
}
