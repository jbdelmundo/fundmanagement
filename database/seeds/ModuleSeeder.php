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
                'id' => 1,
        		'module' => 'Collection',
        	],
        	[
                'id' => 2,
        		'module' => 'Endorsement',
        	],
        	[
                'id' => 3,
        		'module' => 'Requests',
        	],
        	[
                'id' => 4,
        		'module' => 'Approval',
        	],
        	[
                'id' => 5,
        		'module' => 'User Management',
        	],
        	[
                'id' => 6,
        		'module' => 'Semester Management',
        	],
        	[
                'id' => 7,
        		'module' => 'Purchase History',
        	],
        	[
                'id' => 8,
        		'module' => 'Refunds',
        	],
        	[
                'id' => 9,
        		'module' => 'Module Permissions',
        	],
        	[
                'id' => 10,
                'module' => 'Eresource Usage Statistics',
            ],
            [
                'id' => 11,
                'module' => 'Eresource Usage Statistics Encoding',
            ],
            [
                'id' => 12,
                'module' => 'Manual Transactions',
            ],
            [
                'id' => 13,
                'module' => 'Reports Generation',
            ],
            [
                'id' => 14,
                'module' => 'Email Notifications',
            ],
        ];
        foreach ($modules as  $module) {
        	 Module::create($module);
        }
    }
}
