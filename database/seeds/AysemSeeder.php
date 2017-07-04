<?php
use Illuminate\Database\Seeder;
use App\Aysem;
class AysemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $aysems = [];
        for($i=2010; $i <= 2016; $i++) { 
            $aysems[] = $i*10 + 1;
            $aysems[] = $i*10 + 2;
            $aysems[] = $i*10 + 3;
        }
        //  $aysems = [
        //     20161,
        //     20161,
        //     20162,
        //     20163,
        //     20171
        // ];
        foreach ($aysems as $key => $sem) {
            $sem = [ 'aysem' => $sem, 'short_name' => Aysem::shortName($sem) , 'full_name' =>  Aysem::fullName($sem) ];
            Aysem::create( $sem);
        }
    }
   
}