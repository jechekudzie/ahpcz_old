<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateStudentNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('student_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('renewal_period_id');
            $table->string('student_number');
            $table->string('issuer')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE student_numbers CHANGE student_number student_number INT(4) UNSIGNED ZEROFILL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('student_numbers');
    }
}
