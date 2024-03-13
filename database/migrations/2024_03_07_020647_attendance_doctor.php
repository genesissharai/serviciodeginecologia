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

        Schema::table('doctors', function (Blueprint $table) {
            $table->integer("resident")->nullable();
            $table->dropColumn("status");
            $table->dropForeign(['user_id']);
            $table->dropColumn("user_id");
        });
        Schema::rename("doctors", "doctor_hierarchies");

        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger("doctor_hierarchy_id")->nullable();
            $table->foreign('doctor_hierarchy_id')->references('id')->on('doctor_hierarchies')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {

        Schema::dropIfExists('daily_attendance');
        Schema::dropIfExists('operating_room_attendance');
        Schema::dropIfExists('attendance_code');

        Schema::rename("doctor_hierarchies", "doctors");
        Schema::table('doctors', function (Blueprint $table) {
            $table->integer("status")->comment("0: inactivo / 1: activo")->default(0);
            $table->dropColumn("resident");
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
        Schema::table('users', function (Blueprint $table) {
            $table->dropForeign(['doctor_hierarchy_id']);
            $table->dropColumn("doctor_hierarchy_id");
        });
    }
};
