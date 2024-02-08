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
        Schema::create('gynecological_clinical_history', function (Blueprint $table) {
            $table->id();
            $table->text('address')->nullable();
            $table->string('gender')->nullable();
            $table->string('civil_state')->nullable();
            $table->string('have_partner')->nullable();
            $table->longText('reason')->nullable();
            $table->longText('gynecological_history')->nullable();
            $table->date('date_last_menstruation')->nullable();
            $table->longText('transmitted_diseases')->nullable();
            $table->text('contraceptive_method')->nullable();
            $table->longText('family_background')->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('obstetrics_clinical_history', function (Blueprint $table) {
            $table->id();
            $table->double("maternal_weight")->nullable();
            $table->text("blood_pressure")->nullable();
            $table->longText('notes')->nullable();
            $table->unsignedBigInteger('clinical_history_id')->nullable();
            $table->foreign('clinical_history_id')->references('id')->on('gynecological_clinical_history');
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
        Schema::dropIfExists('obstetrics_clinical_history');
        Schema::dropIfExists('gynecological_clinical_history');
    }
};
