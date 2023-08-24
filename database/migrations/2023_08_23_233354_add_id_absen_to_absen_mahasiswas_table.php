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
        Schema::table('absen_mahasiswas', function (Blueprint $table) {
            $table->foreignId('id_absen')->after('id_user');
            $table->foreign('id_absen')->references('id')->on('absens');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('absen_mahasiswas', function (Blueprint $table) {
            //
        });
    }
};
