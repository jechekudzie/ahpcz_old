<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DiscreditedInstitutionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $discredited_institutions = include __DIR__.'/DiscreditedInstitutionsSeeder.php';
        DB::table('discredited_institutions')->insert($discredited_institutions);
    }
}
