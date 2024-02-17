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
        Schema::table('medical_consultations', function (Blueprint $table) {
            $table->datetime('date')->nullable();
            $table->dropColumn('start_date');
            $table->dropColumn('end_date');
            $table->dropColumn('start_hour');
            $table->dropColumn('end_hour');
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
        Schema::table('medical_consultations', function (Blueprint $table) {
            $table->date('start_date');
            $table->date('end_date')->nullable(); //If null it will end 30 min after start
            $table->time('start_hour');
            $table->time('end_hour')->nullable(); //If null it will end 30 min after start
            $table->dropColumn('date');
        });
    }
};
