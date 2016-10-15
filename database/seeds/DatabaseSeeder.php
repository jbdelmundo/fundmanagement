<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $this->call(UsersTableSeeder::class);
        $this->call(DepartmentsSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(AysemSeeder::class);
        $this->call(TransactionTypeSeeder::class);


        $this->call(RandomContent::class);
    }
}
