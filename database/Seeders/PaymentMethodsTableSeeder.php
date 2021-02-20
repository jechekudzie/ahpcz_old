<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentMethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {


        //fetch from  file and run
        $payment_methods = include __DIR__.'/PaymentMethodsSeeder.php';
        DB::table('payment_methods')->insert($payment_methods);

    }
}
