<?php

use Illuminate\Database\Seeder;

class PaymentItemsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //fetch from  file and run
        $payment_items = include __DIR__.'/PaymentItemsSeeder.php';
        DB::table('payment_items')->insert($payment_items);
    }
}
