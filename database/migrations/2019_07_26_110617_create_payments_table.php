<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePaymentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('practitioner_id');
            $table->unsignedInteger('renewal_id')->nullable();
            $table->timestamp('payment_date')->nullable();
            $table->string('renewal_period_id');
            $table->string('month');
            $table->string('day');
            $table->double('amount_invoiced', 8, 2);
            $table->double('amount_paid', 8, 2);
            $table->double('balance', 8, 2);
            $table->string('payment_channel_id');//ecocash/bank/swipe
            $table->string('receipt_number');
            $table->string('payment_item_category_id');
            $table->string('payment_item_id');
            $table->string('pop')->nullable();

            $table->timestamps();
        });
/*        DB::statement('ALTER TABLE payments CHANGE id id INT(6) UNSIGNED ZEROFILL NOT NULL AUTO_INCREMENT');*/
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('payments');
    }
}
