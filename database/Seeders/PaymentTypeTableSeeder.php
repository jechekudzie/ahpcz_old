<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

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
