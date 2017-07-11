<?php

use Illuminate\Database\Seeder;
use App\Module;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
		$modules = [
        	[
        		'module' => 'User Management',
        	],
        	[
        		'module' => 'Semester Management',
        	],
        	[
        		'module' => 'Purchase History',
        	],
        	[
        		'module' => 'Refunds',
        	],
        	[
        		'module' => 'Module Permissions',
        	],
        	[
        		'module' => 'Eresource Usage Statistics',
        	],
        ];
        foreach ($modules as  $module) {
        	 Module::create($module);
        }
    }
}
