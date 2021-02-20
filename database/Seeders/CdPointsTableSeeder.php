<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CdPointsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $cd_points = include __DIR__.'/CdPointsSeeder.php';
        DB::table('cd_points')->insert($cd_points);
    }
}
