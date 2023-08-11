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
        Schema::create('jadwals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_class');
            $table->foreignId('id_ruangan');
            $table->foreignId('id_matakuliah');
            $table->string('time_start');
            $table->string('time_end');
            $table->string('day');
            $table->string('sks');
            $table->timestamps();

            $table->foreign('id_class')->references('id')->on('classes');
            $table->foreign('id_ruangan')->references('id')->on('ruangans');
            $table->foreign('id_matakuliah')->references('id')->on('mata_kuliahs');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('jadwals');
    }
};
