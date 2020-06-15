<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLowonganKerjasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('lowongan_kerjas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user_perusahaan');
            $table->string('nama_perusahaan');
            $table->string('jenis_kerjasama');
            $table->string('judul');
            $table->integer('batas_usia');
            $table->boolean('jenis_kelamin_laki_laki');
            $table->boolean('jenis_kelamin_perempuan');
            $table->date('tgl_tes');
            $table->time('waktu_tes');
            $table->string('lokasi');
            $table->string('status');
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
        Schema::dropIfExists('lowongan_kerjas');
    }
}
