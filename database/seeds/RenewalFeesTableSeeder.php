<?php

use Illuminate\Database\Seeder;

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
