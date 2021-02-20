<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RenewalCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        //fetch from file and run
        $renewal_categories = include __DIR__.'/RenewalCategoriesSeeder.php';
        DB::table('renewal_categories')->insert($renewal_categories);
    }
}
