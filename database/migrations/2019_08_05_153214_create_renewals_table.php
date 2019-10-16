<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRenewalsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewals', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('practitioner_id');
            $table->unsignedInteger('payment_method_id')->nullable();
            $table->unsignedInteger('renewal_category_id');
            $table->string('renewal_period_id');
            $table->string('expiry_date')->nullable();
            $table->double('balance',8,2)->nullable();
            $table->unsignedInteger('renewal_status_id');
            $table->unsignedInteger('payment_type_id');
            $table->unsignedInteger('cdpoints')->nullable();
            $table->unsignedInteger('placement')->nullable();
            $table->unsignedInteger('certificate')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('renewals');
    }
}
