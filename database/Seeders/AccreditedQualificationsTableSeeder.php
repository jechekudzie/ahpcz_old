<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
