<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SystemEntitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        ///fetch from  file and run
        $system_entities = include __DIR__.'/SystemEntitiesSeeder.php';
        DB::table('system_entities')->insert($system_entities);
    }
}
