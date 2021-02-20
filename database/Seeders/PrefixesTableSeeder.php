<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
