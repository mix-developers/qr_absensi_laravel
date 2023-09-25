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
        Schema::create('absen_ijins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_jadwal');
            $table->foreignId('id_user');
            $table->string('latitude');
            $table->string('longitude');
            $table->enum('jenis', ['ijin', 'sakit']);
            $table->text('keterangan');
            $table->string('foto');
            $table->string('tanggal');
            $table->boolean('konfirmasi')->default(0);
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
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
        Schema::dropIfExists('absen_ijins');
    }
};
