<?php

use Illuminate\Database\Seeder;
use App\User;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $users = [
        	[
        		'username' => 'che',
        		'password' => 'wew',
        		'department_id' => 1,
                'userrole_id' => 1
        	],
        	[
        		'username' => 'ce',
        		'password' => 'wew',
        		'department_id' => 2,
                'userrole_id' => 1
        	],
        	[
        		'username' => 'lib',
        		'password' => 'wew',
                'userrole_id' => 2
        	],
        ];
        foreach ($users as $key => $user) {
            $user['password'] = Hash::make($user['password']);
            User::create( $user);
        }
    }
}
