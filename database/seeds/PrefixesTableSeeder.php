<?php

use Illuminate\Database\Seeder;

class PrefixesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        $prefixes = include __DIR__.'/PrefiexesSeeder.php';
        DB::table('prefixes')->insert($prefixes);


    }
}
