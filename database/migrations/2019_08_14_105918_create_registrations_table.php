<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRegistrationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('practitioner_id');
            $table->unsignedInteger('payment_method_id');
            $table->unsignedInteger('renewal_category_id');
            $table->string('renewal_period_id');
            $table->string('expiry_date')->nullable();
            $table->double('balance',8,2)->nullable();
            $table->unsignedInteger('renewal_status_id')->default(1);
            $table->unsignedInteger('payment_type_id')->default(0);
            $table->unsignedInteger('cdpoints')->default(0);
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
        Schema::dropIfExists('registrations');
    }
}
