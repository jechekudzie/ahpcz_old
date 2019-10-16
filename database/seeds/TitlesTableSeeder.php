<?php

use Illuminate\Database\Seeder;

class TitlesTableSeeder extends Seeder
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
        $titles = include __DIR__.'/TitlesSeeder.php';
        DB::table('titles')->insert($titles);
    }
}
