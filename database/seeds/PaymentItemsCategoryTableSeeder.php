<?php

use Illuminate\Database\Seeder;

class PaymentItemsCategoryTableSeeder extends Seeder
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
        $payment_item_categories = include __DIR__.'/PaymentItemsCategorySeeder.php';
        DB::table('payment_item_categories')->insert($payment_item_categories);

    }
}
