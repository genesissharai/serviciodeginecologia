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
        Schema::table('medical_consultations', function (Blueprint $table) {
            $table->dropColumn('date');
            $table->datetime('consultation_date')->nullable();

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
            $table->datetime('date')->nullable();
            $table->dropColumn('consultation_date');

        });
    }
};
