<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionerQualificationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioner_qualifications', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('practitioner_id');
            $table->unsignedBigInteger('profession_id');
            $table->unsignedBigInteger('professional_qualification_id');
            $table->unsignedBigInteger('accredited_institution_id')->nullable();
            $table->unsignedBigInteger('qualification_category_id')->nullable();
            $table->string('institution')->nullable();
            $table->string('professional_qualification_name')->nullable();
            $table->timestamp('commencement_date')->nullable();
            $table->timestamp('completion_date')->nullable();
            $table->string('awarded_by')->nullable();
            $table->timestamp('awarded_date')->nullable();
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
        Schema::dropIfExists('practitioner_qualifications');
    }
}
