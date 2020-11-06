<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePractitionersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('practitioners', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('title_id');
            $table->unsignedBigInteger('gender_id');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('previous_name')->nullable();
            $table->string('dob')->nullable();
            $table->string('id_number');
            $table->string('prefix')->nullable();
            $table->unsignedInteger('registration_number')->nullable();
            $table->integer('registration_certificate')->default(0);
            $table->unsignedInteger('register_category_id')->nullable();
            $table->unsignedBigInteger('profession_id');
            $table->unsignedBigInteger('qualification_category_id');
            $table->unsignedBigInteger('renewal_category_id')->nullable();
            $table->unsignedBigInteger('payment_method_id')->nullable();

            $table->unsignedBigInteger('nationality_id')->nullable();
            $table->unsignedBigInteger('province_id')->nullable();
            $table->unsignedBigInteger('city_id')->nullable();

            $table->unsignedBigInteger('professional_qualification_id')->nullable();
            $table->unsignedBigInteger('accredited_institution_id')->nullable();
            $table->string('institution')->nullable();
            $table->string('commencement_date')->nullable();
            $table->string('completion_date')->nullable();

            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('system_entity_id')->default(1);
            $table->unsignedBigInteger('approval_status')->default(0);

            $table->string('registration_period');
            $table->string('registration_month');
            //approval stages
            $table->unsignedInteger('accountant')->default(0);
            $table->unsignedInteger('registration_officer')->default(0);
            $table->unsignedInteger('member')->default(0);
            $table->unsignedInteger('registrar')->default(0);
            $table->timestamps();
        });
        DB::statement('ALTER TABLE practitioners CHANGE registration_number registration_number INT(4) UNSIGNED ZEROFILL');

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('practitioners');
    }
}
