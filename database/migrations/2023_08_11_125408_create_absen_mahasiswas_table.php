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
        Schema::create('absen_mahasiswas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal');
            $table->foreignId('id_user');
            $table->timestamps();

            $table->foreign('id_jadwal')->references('id')->on('jadwals');
            $table->foreign('id_user')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('absen_mahasiswas');
    }
};
