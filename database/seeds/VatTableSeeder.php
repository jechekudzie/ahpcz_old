<?php

use Illuminate\Database\Seeder;

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
