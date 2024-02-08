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
        Schema::create('morbidity', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('date');
            $table->string('hour');
            $table->string('name');
            $table->string('last_name');
            $table->string('ci');
            $table->string('age');
            $table->string('pregnancies');
            $table->string('fvr');
            $table->string('ev_x_fur');
            $table->string('first_eco');
            $table->string('eg_x_eco');
            $table->string('ta');
            $table->string('au');
            $table->string('physical_exam');
            $table->string('conduct');
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
        Schema::dropIfExists('morbidity');
    }
};
