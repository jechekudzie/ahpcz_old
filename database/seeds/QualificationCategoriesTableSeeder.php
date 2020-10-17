<?php

use Illuminate\Database\Seeder;

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
