<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Model;
use App\PesertaRekrutmen;
use Faker\Generator as Faker;

$factory->define(PesertaRekrutmen::class, function (Faker $faker) {
    return [
        'status' => 'Terdaftar',
    ];
});
