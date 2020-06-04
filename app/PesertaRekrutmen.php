<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PesertaRekrutmen extends Model
{
    protected $fillable = [
        'id_user', 
        'id_lowongan', 
        'status', 
    ];
}
