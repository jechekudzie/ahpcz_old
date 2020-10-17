<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStudentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('title_id');
            $table->unsignedBigInteger('gender_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('previous_name')->nullable();
            $table->string('dob');
            $table->string('id_number');
            $table->unsignedBigInteger('marital_status_id');

            $table->string('registration_number')->nullable();
            $table->unsignedBigInteger('profession_id');

            $table->unsignedBigInteger('nationality_id');
            $table->unsignedBigInteger('province_id');
            $table->unsignedBigInteger('city_id');

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('system_entity_id');
            $table->unsignedBigInteger('approval_status')->default(false);

            $table->string('registration_period');
            $table->string('registration_month');
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
        Schema::dropIfExists('students');
    }
}
