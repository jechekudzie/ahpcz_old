<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerContactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_contacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('practitioner_id')->unique();
            $table->string('email')->nullable();;
            $table->string('primary_phone')->nullable();
            $table->string('secondary_phone')->nullable();
            $table->text('physical_address')->nullable();;
            $table->unsignedInteger('province_id')->nullable();;
            $table->unsignedInteger('city_id')->nullable();;
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
        Schema::dropIfExists('practitioner_contacts');
    }
}
