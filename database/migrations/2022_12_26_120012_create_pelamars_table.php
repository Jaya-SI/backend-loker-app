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
        Schema::create('pelamars', function (Blueprint $table) {
            $table->id();

            $table->string('nama');
            $table->string('img_pelamar')->nullable();
            $table->string('email')->unique();
            $table->string('password');
            $table->text('alamat');
            $table->string('no_hp');
            $table->string('jenis_kelamin');
            $table->string('role');
            $table->text('token')->nullable();
            $table->string('cv')->nullable();

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
        Schema::dropIfExists('pelamars');
    }
};
