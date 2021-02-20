<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProfessionalQualificationTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $professional_qualifications = include __DIR__.'/ProfessionalQualificationSeeder.php';
        DB::table('professional_qualifications')->insert($professional_qualifications);

    }
}
