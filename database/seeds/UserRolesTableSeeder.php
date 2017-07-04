<?php

use Illuminate\Database\Seeder;

class UserRolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $userroles = [
    		[
    			'id' => '1',
    			'role' => 'LFC',    			
    		],
    		[
    			'id' => '2',
    			'role' => 'Librarian',    			
    		],
    		[
    			'id' => '3',
    			'role' => 'Department/Institue Head',    			
    		],
    		
    	];
        DB::table('user_roles')->insert($userroles);
    }
}
