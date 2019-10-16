<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePrefixesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('prefixes', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('profession_id');
            $table->string('name');
            $table->unsignedInteger('last_reg')->nullable();
            $table->timestamps();
        });
               DB::statement('ALTER TABLE prefixes CHANGE last_reg last_reg INT(4) UNSIGNED ZEROFILL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('prefixes');
    }
}
