<?php

use Illuminate\Database\Seeder;

class RenewalPeriodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //fetch from  file and run
        $renewal_periods = include __DIR__.'/RenewalPeriodsSeeder.php';
        DB::table('renewal_periods')->insert($renewal_periods);
    }
}
