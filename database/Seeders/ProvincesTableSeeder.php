<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $provinces = include __DIR__.'/ProvincesSeeder.php';
        DB::table('provinces')->insert($provinces);

    }
}
