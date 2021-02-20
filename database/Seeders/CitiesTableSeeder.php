<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $cities = include __DIR__.'/CitiesSeeder.php';
        DB::table('cities')->insert($cities);
    }
}
