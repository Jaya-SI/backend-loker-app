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
        Schema::create('seleksis', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_pelamar');
            $table->unsignedBigInteger('id_loker');
            $table->text('surat_lamaran')->nullable();
            $table->enum('status', ['seleksi', 'interview'])->default('seleksi');
            $table->text('keterangan')->nullable();

            //relasi ke tabel pelamar
            $table->foreign('id_pelamar')->references('id')->on('pelamars');
            //relasi ke tabel loker
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
        Schema::dropIfExists('seleksis');
    }
};
