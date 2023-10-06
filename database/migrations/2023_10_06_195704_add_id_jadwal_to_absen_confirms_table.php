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
        Schema::table('absen_confirms', function (Blueprint $table) {
            $table->foreignId('id_jadwal')->after('id');

            $table->foreign('id_jadwal')->references('id')->on('jadwals');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absen_confirms', function (Blueprint $table) {
            //
        });
    }
};
