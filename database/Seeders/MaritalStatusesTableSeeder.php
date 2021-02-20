<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MaritalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $marital_statuses = include __DIR__.'/MaritalStatusesSeeder.php';
        DB::table('marital_statuses')->insert($marital_statuses);
    }
}
