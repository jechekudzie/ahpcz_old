<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RegisterCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $register_categories = include __DIR__.'/RegisterCategoriesSeeder.php';
        DB::table('register_categories')->insert($register_categories);
    }
}
