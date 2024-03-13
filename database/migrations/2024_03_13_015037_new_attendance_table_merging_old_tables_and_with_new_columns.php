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

        Schema::create('attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->datetime('attendance_date')->nullable();
            $table->string('type');
            $table->string('subject')->nullable();
            $table->timestamps();
        });

        Schema::dropIfExists('daily_attendance');
        Schema::dropIfExists('operating_room_attendance');
        Schema::dropIfExists('attendance_code');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        //
        Schema::dropIfExists('attendance');
        Schema::create('daily_attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->datetime('attendance_date')->nullable();


            $table->timestamps();
        });

        Schema::create('operating_room_attendance', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->datetime('attendance_date')->nullable();
            $table->timestamps();
        });

        Schema::create('attendance_code', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('doctor_id');
            $table->string('code');
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }
};
