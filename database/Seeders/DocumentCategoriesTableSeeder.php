<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DocumentCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from  file and run
        $document_categories = include __DIR__.'/DocumentCategoriesSeeder.php';
        DB::table('document_categories')->insert($document_categories);

    }
}
