<?php

use Illuminate\Database\Seeder;

class AccreditedInstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    //
    public function run()
    {
        //fetch from  file and run
        $accredited_institutions = include __DIR__ . '/AccreditedInstitutionsSeeder.php';
        DB::table('accredited_institutions')->insert($accredited_institutions);
    }

}
