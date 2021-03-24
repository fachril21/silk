<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PesertaRekrutmen extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('peserta_rekrutmens', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->bigInteger('id_user');
            $table->bigInteger('id_lowongan');
            $table->boolean('konfirmasi_kehadiran')->nullable();
            $table->string('status');
            $table->string('info_status')->nullable();
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
        //
    }
}
