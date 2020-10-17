<?php

use Illuminate\Database\Seeder;

class NationalitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $nationalities = include __DIR__.'/NationalitiesSeeder.php';
        DB::table('nationalities')->insert($nationalities);
    }
}
