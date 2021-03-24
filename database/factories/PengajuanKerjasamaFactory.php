<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\PengajuanKerjasama;
use Faker\Generator as Faker;

$factory->define(PengajuanKerjasama::class, function (Faker $faker) {
    return [
        'jenis_kerjasama' => 'Rekrutmen Dalam Kampus',
        'judul' => $faker->words(3, true), 
        'batas_usia' => $faker->randomNumber(2), 
        'jenis_kelamin_laki_laki' => $faker->boolean(), 
        'jenis_kelamin_perempuan' => $faker->boolean(), 
        'status' => 'Diajukan',
    ];
});
