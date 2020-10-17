<?php

use Illuminate\Database\Seeder;

class PractitionerRegistrationFeesTableSeeder extends Seeder
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
        $practitioner_registration_fees = include __DIR__.'/PractitionerRegistrationFeesSeeder.php';
        DB::table('registration_fees')->insert($practitioner_registration_fees);

    }
}
