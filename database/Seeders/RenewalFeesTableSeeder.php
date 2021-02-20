<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RenewalFeesTableSeeder extends Seeder
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
        $renewal_fees = include __DIR__.'/RenewalFeesSeeder.php';
        DB::table('renewal_fees')->insert($renewal_fees);
    }
}
