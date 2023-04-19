<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class CreateCertificateNumbersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('certificate_numbers', function (Blueprint $table) {
            $table->id();
            $table->string('renewal_period_id');
            $table->string('certificate_number');
            $table->string('issuer')->nullable();
            $table->timestamps();
        });
        DB::statement('ALTER TABLE certificate_numbers CHANGE certificate_number certificate_number INT(4) UNSIGNED ZEROFILL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('certificate_numbers');
    }
}
