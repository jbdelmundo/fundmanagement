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
                'username' => 'lib',
                'password' => 'wew',
                'userrole_id' => 2
            ],
            [
                'username' => 'admin',
                'password' => 'wew',
                'userrole_id' => 3
            ],

            [
                'username' => 'che',
                'password' => '123',
                'department_id' => 1,
                'userrole_id' => 1
            ],
            [
                'username' => 'ce',
                'password' => '123',
                'department_id' => 2,
                'userrole_id' => 1
            ],
            [
                'username' => 'cs',
                'password' => '123',
                'department_id' => 3,
                'userrole_id' => 1
            ],
            [
                'username' => 'eee',
                'password' => '123',
                'department_id' => 4,
                'userrole_id' => 1
            ],
            [
                'username' => 'egye',
                'password' => '123',
                'department_id' => 5,
                'userrole_id' => 1
            ],
            [
                'username' => 'ene',
                'password' => '123',
                'department_id' => 6,
                'userrole_id' => 1
            ],
            [
                'username' => 'ge',
                'password' => '123',
                'department_id' => 7,
                'userrole_id' => 1
            ],
            [
                'username' => 'ie',
                'password' => '123',
                'department_id' => 8,
                'userrole_id' => 1
            ],
            [
                'username' => 'me',
                'password' => '123',
                'department_id' => 9,
                'userrole_id' => 1
            ],
            [
                'username' => 'mmm',
                'password' => '123',
                'department_id' => 10,
                'userrole_id' => 1
            ],
            [
                'username' => 'es',
                'password' => '123',
                'department_id' => 11,
                'userrole_id' => 1
            ],
            [
                'username' => 'genref',
                'password' => '123',
                'department_id' => 12,
                'userrole_id' => 1
            ],
            [
                'username' => 'erdt',
                'password' => '123',
                'department_id' => 13,
                'userrole_id' => 1
            ],

            // chair
            [
                'username' => 'che_chair',
                'password' => '123',
                'department_id' => 1,
                'userrole_id' => 3
            ],
            [
                'username' => 'ce_chair',
                'password' => '123',
                'department_id' => 2,
                'userrole_id' => 3
            ],
            [
                'username' => 'cs_chair',
                'password' => '123',
                'department_id' => 3,
                'userrole_id' => 3
            ],
            [
                'username' => 'eee_chair',
                'password' => '123',
                'department_id' => 4,
                'userrole_id' => 3
            ],
            [
                'username' => 'egye_chair',
                'password' => '123',
                'department_id' => 5,
                'userrole_id' => 3
            ],
            [
                'username' => 'ene_chair',
                'password' => '123',
                'department_id' => 6,
                'userrole_id' => 3
            ],
            [
                'username' => 'ge_chair',
                'password' => '123',
                'department_id' => 7,
                'userrole_id' => 3
            ],
            [
                'username' => 'ie_chair',
                'password' => '123',
                'department_id' => 8,
                'userrole_id' => 3
            ],
            [
                'username' => 'me_chair',
                'password' => '123',
                'department_id' => 9,
                'userrole_id' => 1
            ],
            [
                'username' => 'mmm_chair',
                'password' => '123',
                'department_id' => 10,
                'userrole_id' => 3
            ],
            [
                'username' => 'es_chair',
                'password' => '123',
                'department_id' => 11,
                'userrole_id' => 3
            ]
        
            
        ];
        foreach ($users as $key => $user) {
            $user['password'] = Hash::make($user['password']);
            User::create( $user);
        }
    }
}
