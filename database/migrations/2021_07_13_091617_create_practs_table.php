<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePractsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practs', function (Blueprint $table) {
            $table->id();
            $table->string('idd')->nullable();
            $table->string('case_number')->nullable();
            $table->string('date')->nullable();
            $table->string('block')->nullable();
            $table->string('iucr')->nullable();
            $table->string('primary_type')->nullable();
            $table->string('description')->nullable();
            $table->string('location_description')->nullable();
            $table->string('arrest')->nullable();
            $table->string('domestic')->nullable();
            $table->string('beat')->nullable();
            $table->string('district')->nullable();
            $table->string('ward')->nullable();
            $table->string('community_area')->nullable();
            $table->string('fbi_code')->nullable();
            $table->string('x_coordinate')->nullable();
            $table->string('y_coordinate')->nullable();
            $table->string('year')->nullable();
            $table->string('updated_on')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->string('location')->nullable();
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
        Schema::dropIfExists('practs');
    }
}
