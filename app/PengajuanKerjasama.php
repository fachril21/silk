<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PengajuanKerjasama extends Model
{
    protected $fillable = [
        'jenis_kerjasama', 
        'judul', 
        'batas_usia', 
        'jenis_kelamin_laki_laki', 
        'jenis_kelamin_perempuan', 
        'status',
    ];
}
