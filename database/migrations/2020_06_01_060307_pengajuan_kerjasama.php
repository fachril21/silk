<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class PengajuanKerjasama extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('pengajuanKerjasama', function (Blueprint $table) {
            $table->id()->autoIncrement();
            $table->string('jenis_kerjasama');
            $table->string('judul');
            $table->integer('batas_usia');
            $table->boolean('jenis_kelamin_laki_laki');
            $table->boolean('jenis_kelamin_perempuan');
            $table->string('lulusan_pelamar');
            $table->string('posisi');
            $table->string('informasi_posisi');
            $table->date('tgl_tawaran')->nullable($value = true);
            $table->string('lokasi')->nullable($value = true);
            $table->date('tgl_usulan')->nullable($value = true);
            $table->string('alasan_usulan')->nullable($value = true);
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
        //
    }
}
