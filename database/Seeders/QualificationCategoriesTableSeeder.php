<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class QualificationCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from file and run
        $qualification_categories = include __DIR__.'/QualificationCategoriesSeeder.php';
        DB::table('qualification_categories')->insert($qualification_categories);
    }
}
