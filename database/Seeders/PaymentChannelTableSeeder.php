<?php
namespace Database\Seeders;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PaymentChannelTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $payment_channels = include __DIR__.'/PaymentChannelSeeder.php';
        DB::table('payment_channels')->insert($payment_channels);
    }
}
