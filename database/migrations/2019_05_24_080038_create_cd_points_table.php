<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCdPointsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cd_points', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profession_id')->unique();
            $table->integer('points');
            $table->integer('placement')->nullable();
            $table->unsignedBigInteger('requirement_status')->nullable();
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
        Schema::dropIfExists('cd_points');
    }
}
