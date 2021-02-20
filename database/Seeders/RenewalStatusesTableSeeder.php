<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RenewalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        ///fetch from  file and run
        $renewal_statuses = include __DIR__.'/RenewalStatusesSeeder.php';
        DB::table('renewal_statuses')->insert($renewal_statuses);

    }
}
