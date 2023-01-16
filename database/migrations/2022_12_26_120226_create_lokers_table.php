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
        Schema::create('lokers', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('id_category');
            $table->unsignedBigInteger('id_hrd');
            $table->string('nama');
            $table->string('img_loker');
            $table->text('alamat');
            $table->string('tanggal');
            $table->text('deskripsi1');
            $table->text('deskripsi2');
            $table->text('deskripsi3');
            $table->integer('gaji');
            $table->enum('status', ['open', 'close'])->default('open');


            //relasi ke tabel category
            $table->foreign('id_category')->references('id')->on('category_lokers');
            //relasi ke tabel hrd
            $table->foreign('id_hrd')->references('id')->on('hrds');

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
        Schema::dropIfExists('lokers');
    }
};
