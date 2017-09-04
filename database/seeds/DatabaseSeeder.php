<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
    
    1) Departments
    2) UserRoles (Librarian,LFC,DeptHead types)
    3) Users
    4) Available Aysems
    5) Transaction Types: Collection, Purchase, Adjustment, Refund
    6) Request Statuses: Recorded, Endorsed, Approved, For Purchase, Purchased, Delivered, Refunded
    7) Accounts: Initalize to zero all starting balance
    8) ModuleSeeder: All available modules

     *
     * @return void
     */
    public function run()
    {
        
        $this->call(DepartmentsSeeder::class);
        $this->call(UserRolesTableSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AysemSeeder::class);
        $this->call(TransactionTypeSeeder::class);
        $this->call(RequestStatusesSeeder::class);
        $this->call(AccountsSeeder::class);
        $this->call(ModuleSeeder::class);

        $this->call(ModuleUserSeeder::class);


        // $this->call(RandomContent::class);
    }
}
