<?php

use Illuminate\Database\Seeder;

class IdentificationCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from  file and run
        $identification_categories = include __DIR__.'/IdentificationCategoriesSeeder.php';
        DB::table('identification_categories')->insert($identification_categories);

    }
}
