<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePengajuanKerjasamasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuan_kerjasamas', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_user');
            $table->string('nama_perusahaan');
            $table->string('jenis_kerjasama');
            $table->string('judul');
            $table->integer('batas_usia');
            $table->tinyInteger('jenis_kelamin_laki_laki');
            $table->tinyInteger('jenis_kelamin_perempuan');
            $table->date('tgl_tawaran')->nullable();
            $table->time('waktu_tes')->nullable();
            $table->string('lokasi')->nullable();
            $table->date('tgl_usulan')->nullable();
            $table->string('alasan_usulan')->nullable();
            $table->date('tgl_tes_final')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('pengajuan_kerjasamas');
    }
}
