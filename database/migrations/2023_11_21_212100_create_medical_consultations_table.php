<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('medical_consultations', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users');
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->date('start_date');
            $table->date('end_date')->nullable(); //If null it will end 30 min after start
            $table->time('start_hour');
            $table->time('end_hour')->nullable(); //If null it will end 30 min after start
            $table->string("status")->nullable();
            $table->longText('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('medical_calendar', function (Blueprint $table) { //puede cambiarse las columnas
            $table->id();
            $table->unsignedBigInteger('doctor_id');
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->date('start_date');
            $table->date('end_date')->nullable(); //If null it will end 30 min after start
            $table->time('start_hour');
            $table->time('end_hour')->nullable(); //If null it will end 30 min after start
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
        Schema::dropIfExists('medical_calendar');
        Schema::dropIfExists('medical_consultations');
    }
};
