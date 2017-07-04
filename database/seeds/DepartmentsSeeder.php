<?php

use Illuminate\Database\Seeder;
use App\Department;

class DepartmentsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $depts= [
	        [
	        	'initials'=> 'ChE',
	        	'short_name' => 'Chemical Engineering',
	        	'full_name' => 'Department of Chemical Engineering'
	        ],
	        [
	        	'initials'=> 'CE',
	        	'short_name' => 'Civil Engineering',
	        	'full_name' => 'Department of Civil Engineering'
	        ],
	        [
	        	'initials'=> 'CS',
	        	'short_name' => 'Computer Science',
	        	'full_name' => 'Department of Computer Science'
	        ],
	        [
	        	'initials'=> 'EEE',
	        	'short_name' => 'Electrical and Electronics Engineering',
	        	'full_name' => 'Electrical and Electronics Engineering Institute'
	        ],
	        [
	        	'initials'=> 'EgyE',
	        	'short_name' => 'Energy Engineering',
	        	'full_name' => 'Energy Engineering Program'
	        ],
	        [
	        	'initials'=> 'EnE',
	        	'short_name' => 'Environmental Engineering',
	        	'full_name' => 'Environmental Engineering Program'
	        ],
	        [
	        	'initials'=> 'GE',
	        	'short_name' => 'Geodetic Engineering',
	        	'full_name' => 'Department of Geodetic Engineering'
	        ],
	        [
	        	'initials'=> 'IE',
	        	'short_name' => 'Industrial Engineering and Operations Research',
	        	'full_name' => 'Department of Industrial Engineering and Operations Research'
	        ],
	        [
	        	'initials'=> 'ME',
	        	'short_name' => 'Mechanical Engineering',
	        	'full_name' => 'Department of Mechanical Engineering'
	        ],
	        [
	        	'initials'=> 'MMM',
	        	'short_name' => 'Metallurgical, Mining and Materials Engineering',
	        	'full_name' => 'Department of Metallurgical, Mining and Materials Engineering'
	        ],
	        [
	        	'initials'=> 'ES',
	        	'short_name' => 'Engineering Science',
	        	'full_name' => 'Department of Engineering Science',
	        	'percent_allocation' => 7.0
	        ],
	        [
	        	'initials'=> 'GenRef',
	        	'short_name' => 'General Reference',
	        	'full_name' => 'General References',
	        	'percent_allocation' => 5.0
	        ],
	        [
	        	'initials'=> 'ERDT',
	        	'short_name' => 'Engineering Research and Development for Technology',
	        	'full_name' => 'Engineering Research and Development for Technology',
	        	'percent_allocation' => 0.0
	        ],
        ];
        foreach ($depts as  $dept) {
        	 Department::create($dept);
        }
       
    }
}
