<?php

use Illuminate\Database\Seeder;

class ProfessionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //fetch from  file and run
        $professions = include __DIR__.'/ProfessionsSeeder.php';
        DB::table('professions')->insert($professions);
    }
}
