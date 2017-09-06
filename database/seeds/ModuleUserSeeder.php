<?php

use Illuminate\Database\Seeder;
use App\User;
use App\ModuleUser;

class ModuleUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        
        //
        $lfc_modules = [
                        2   //Endorsement                                                
                        ,7  //Purchase History
                        ,10 //E-resource Usage Statistics
                        ];

        $lib_modules = [
                        1   //Collection
                        ,3  //Requests
                        ,4  //Approval
                        ,5  //User Management
                        ,6  //Semester Management
                        ,8  //Refunds
                        ,10 //Eresource Statistics
                        ,11 //Eresource Statistics Encoding
                        ];
        
        $lib_modules[] = 2;
        $lib_modules[] = 7;


        $deptchair_modules = $lfc_modules;
        $deptchair_modules[] = 4;   //add approval module



        $lfc_users = User::where('userrole_id', 1)->get();        
        foreach ($lfc_users as $key => $user) {
            foreach ($lfc_modules as  $moduleid) {
                ModuleUser::create(['user_id' => $user->id , 'module_id' => $moduleid]);
            }
        }

        $lib_users = User::where('userrole_id', 2)->get();        
        foreach ($lib_users as $key => $user) {
            foreach ($lib_modules as  $moduleid) {
                ModuleUser::create(['user_id' => $user->id , 'module_id' => $moduleid]);
            }
        }

        $chair_users = User::where('userrole_id', 3)->get();        
        foreach ($chair_users as $key => $user) {
            foreach ($deptchair_modules as  $moduleid) {
                ModuleUser::create(['user_id' => $user->id , 'module_id' => $moduleid]);
            }
        }

        // add permissionsmodule to admin
        $admin = User::where('username', 'admin')->first();
        ModuleUser::create(['user_id' => $admin->id , 'module_id' => 9]);
		
    }
}
