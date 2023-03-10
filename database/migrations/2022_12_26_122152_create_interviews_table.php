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
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_seleksi');
            $table->unsignedBigInteger('id_hrd');
            $table->unsignedBigInteger('id_pelamar');
            $table->unsignedBigInteger('id_loker');
            $table->string('jadwal');
            $table->text('token')->nullable();
            $table->text('keterangan')->nullable();
            $table->enum('status', ['Diterima', 'Ditolak', 'Interview'])->default('Interview');

            //relasi ke tabel seleksi
            $table->foreign('id_seleksi')->references('id')->on('seleksis');
            //relasi ke tabel hrd
            $table->foreign('id_hrd')->references('id')->on('hrds');
            //relasi ke tabel pelamar
            $table->foreign('id_pelamar')->references('id')->on('pelamars');
            //relasi ke table loker
            $table->foreign('id_loker')->references('id')->on('lokers');

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
        Schema::dropIfExists('interviews');
    }
};
