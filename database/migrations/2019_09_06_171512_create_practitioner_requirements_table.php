<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerRequirementsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_requirements', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedInteger('practitioner_id');
            $table->unsignedInteger('requirement_id');
            $table->boolean('status')->default(false);
            $table->boolean('member_status')->default(false);
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
        Schema::dropIfExists('practitioner_requirements');
    }
}
