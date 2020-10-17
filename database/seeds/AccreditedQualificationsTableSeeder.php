<?php

use Illuminate\Database\Seeder;

class AccreditedQualificationsTableSeeder extends Seeder
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
        $accredited_qualifications = include __DIR__ . '/AccreditedQualificationsSeeder.php';
        DB::table('accreditations')->insert($accredited_qualifications);

    }
}
