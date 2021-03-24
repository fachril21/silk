<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\LowonganKerja;
use App\Model;
use Faker\Generator as Faker;

$factory->define(LowonganKerja::class, function (Faker $faker) {
    return [
        'jenis_kerjasama' => 'Rekrutmen Dalam Kampus',
        'judul' => $this->faker->words(3, true),
        'batas_usia' => $this->faker->randomNumber(2),
        'jenis_kelamin_laki_laki' => $this->faker->boolean(),
        'jenis_kelamin_perempuan' => $this->faker->boolean(),
        'tgl_tes' => $this->faker->date(),
        'waktu_tes' => $this->faker->time(),
        'lokasi' => $this->faker->streetAddress,
        'status' => 'Berjalan',
    ];
});
