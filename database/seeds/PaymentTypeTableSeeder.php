<?php

use Illuminate\Database\Seeder;

class PaymentTypeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $payment_types = include __DIR__.'/PaymentTypeSeeder.php';
        DB::table('payment_types')->insert($payment_types);

    }
}
