<?php

use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from  file and run
        $roles = include __DIR__.'/RolesSeeder.php';
        DB::table('roles')->insert($roles);
    }
}
