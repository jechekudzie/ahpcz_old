<?php

use Illuminate\Database\Seeder;

class RequirementsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $requirements = include __DIR__.'/RequirementsSeeder.php';
        DB::table('requirements')->insert($requirements);

    }
}
