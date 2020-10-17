<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerExperiencesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_experiences', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('practitioner_id');
            $table->string('name');
            $table->text('business_address');
            $table->unsignedInteger('province_id');
            $table->unsignedInteger('city_id');
            $table->string('contact_person');
            $table->string('email');
            $table->string('phone');
            $table->string('job_title');
            $table->timestamp('commencement_date');
            $table->timestamp('resignation_date')->nullable();

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
        Schema::dropIfExists('practitioner_experiences');
    }
}
