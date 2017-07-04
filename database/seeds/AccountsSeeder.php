<?php

use Illuminate\Database\Seeder;

class AccountsSeeder extends Seeder
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

        	$dept->accounts()->create([
        		'aysem' => App\Aysem::current()->aysem,
        		'begining_balance' => 0,
        		'ending_balance' => 0
    		]);


        }
    }
}
