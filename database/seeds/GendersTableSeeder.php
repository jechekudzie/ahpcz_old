<?php

use Illuminate\Database\Seeder;

class GendersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from  file and run
        $genders = include __DIR__.'/GendersSeeder.php';
        DB::table('genders')->insert($genders);
    }
}

