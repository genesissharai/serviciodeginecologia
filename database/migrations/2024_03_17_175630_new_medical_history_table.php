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
        //



        Schema::create('medical_history', function (Blueprint $table) {
            $table->id();


            $table->unsignedBigInteger('patient_id');
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('doctor_id')->nullable();
            $table->foreign('doctor_id')->references('id')->on('users');
            $table->timestamps();
        });

        Schema::create('patient_data', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->text('address')->nullable();
            $table->string('sex')->nullable();
            $table->string('ci')->nullable();
            $table->string('civil_status')->nullable();
            $table->string('nationality')->nullable();
            $table->date('birthdate')->nullable();
            $table->string('place_of_birth')->nullable();
            $table->string('occupation')->nullable();
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->timestamps();
        });

        Schema::create('emergency_contact', function (Blueprint $table) {
            $table->id();
            $table->string('fullname')->nullable();
            $table->string('relationship')->nullable();
            $table->string('address')->nullable();
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->timestamps();
        });

        Schema::create('medical_history_first_part', function (Blueprint $table) {
            $table->id();
            $table->date('date_of_admission')->nullable();
            $table->time('hour_of_admission')->nullable();
            $table->date('previous_date_of_admission')->nullable();
            $table->longText('reason_for_admission')->nullable();
            $table->longText('current_illness')->nullable();
            $table->longText('final_diagnosis')->nullable();
            $table->longText('provisional_diagnosis')->nullable();
            $table->longText('anatopathological_diagnosis')->nullable();
            $table->longText('egress_reason')->nullable();
            $table->date('egress_date')->nullable();
            $table->time('egress_hour')->nullable();
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->timestamps();
        });

        Schema::create('medical_history_second_part', function (Blueprint $table) {
            $table->id();
            $table->longText('diagnosis')->nullable();
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->timestamps();
        });

        Schema::create('medical_history_third_part', function (Blueprint $table) {
            $table->id();
            $table->string('temperature_celcius')->nullable();
            $table->string('pulse')->nullable();
            $table->string('bpm_breathing')->nullable();
            $table->string('max_blood_pressure')->nullable();
            $table->string('min_blood_pressure')->nullable();
            $table->string('weight_kgs')->nullable();
            $table->longText('diagnosis')->nullable();
            $table->date('exam_date')->nullable();
            $table->string('exam_made_by')->nullable();
            $table->longText('service_diagnosis')->nullable();
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->timestamps();
        });

        Schema::create('diagnosis_parameters_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->string('subtitle')->nullable();
            $table->integer('cardinality')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('diagnosis_parameters_categories');
            $table->timestamps();
        });


        Schema::create('diagnosis_parameters', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->integer('cardinality')->nullable();

            $table->unsignedBigInteger('parent_id')->nullable();
            $table->foreign('parent_id')->references('id')->on('diagnosis_parameters');

            $table->unsignedBigInteger('category');
            $table->foreign('category')->references('id')->on('diagnosis_parameters_categories');
            $table->timestamps();
        });



        Schema::create('med_history_diagnosis_params', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('medical_history_id');
            $table->foreign('medical_history_id')->references('id')->on('medical_history');
            $table->unsignedBigInteger('diagnosis_parameter_id');
            $table->foreign('diagnosis_parameter_id')->references('id')->on('diagnosis_parameters');
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
        //
    }
};
