<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RenewalPeriodsTableSeeder extends Seeder
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
        $renewal_periods = include __DIR__.'/RenewalPeriodsSeeder.php';
        DB::table('renewal_periods')->insert($renewal_periods);
    }
}
