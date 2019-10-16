<?php

use Illuminate\Database\Seeder;

class StudentRegistrationFeesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $student_registration_fees = include __DIR__.'/StudentRegistrationFeesSeeder.php';
        DB::table('student_registration_fees')->insert($student_registration_fees);
    }
}
