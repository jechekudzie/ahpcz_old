<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VatTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        //fetch from  file and run
        $vat = include __DIR__.'/VatSeeder.php';
        DB::table('vats')->insert($vat);

    }
}
