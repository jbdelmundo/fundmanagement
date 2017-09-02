<?php

use Illuminate\Database\Seeder;

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
		$module_user = ['module_id' => 9,'user_id' => 1,];
		\App\ModuleUser::create($module_user);
    }
}
