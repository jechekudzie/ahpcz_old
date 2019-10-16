<?php

use Illuminate\Database\Seeder;

class OperationalStatusesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $operational_statuses = include __DIR__.'/OperationalStatusesSeeder.php';
        DB::table('operational_statuses')->insert($operational_statuses);
    }
}
