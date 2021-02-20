<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationLevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from file and run
        $qualification_levels = include __DIR__.'/QualificationLevelsSeeder.php';
        DB::table('qualification_levels')->insert($qualification_levels);



    }
}
