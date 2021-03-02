<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRenewalCriteriasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('renewal_criterias', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('renewal_category_id');
            $table->unsignedBigInteger('employment_status_id');
            $table->unsignedBigInteger('employment_location_id');
            $table->string('certificate_request');
            $table->string('percentage');
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
        Schema::dropIfExists('renewal_criterias');
    }
}
