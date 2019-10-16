<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        //fetch from  file and run
        $users = include __DIR__.'/UsersSeeder.php';
        DB::table('users')->insert($users);


    }
}
