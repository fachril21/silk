<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('userProfile', function () {
    return view('profile');
});
Route::get('/profile/{username}', 'UserProfileController@userData')->name('profile');
Route::get('/profile/edit/{id}', 'UserProfileController@sendUserData')->name('profile.edit');
Route::post('/profile/update', 'UserProfileController@update');
Route::post('/profile/updateEmail/', 'UserProfileController@changeEmail');
Route::patch('/profile/updatePassword/', 'UserProfileController@changePassword')
    ->name('user.password.update');

Route::get('/profilePerusahaan/{username}', 'PerusahaanProfileController@userData')->name('profile.perusahaan');
Route::get('/profilePerusahaan/edit/{id}', 'PerusahaanProfileController@sendUserData')->name('profile.perusahaan.edit');
Route::post('/profilePerusahaan/update', 'PerusahaanProfileController@update');
Route::post('/profilePerusahaan/updateEmail', 'PerusahaanProfileController@changeEmail');
Route::patch('/profilePerusahaan/updatePassword/', 'PerusahaanProfileController@changePassword')
    ->name('perusahaan.password.update');

// Route::get('/kerjasamaRekrutmen', function () {
//     return view('kerjasamaRekrutmen');
// })->name('kerjasamaRekrutmenView');
Route::get('/kerjasamaRekrutmen/{id}', 'PengajuanKerjasamaController@showKerjaSama')->name('kerjasamaRekrutmen');
Route::get('/pengajuanKerjasama', 'PengajuanKerjasamaController@index')->name('pengajuanKerjasama');
Route::post('/pengajuanKerjasama/upload', 'PengajuanKerjasamaController@ajukanKerjasama');

Route::get('/detailKerjasama/{id}', 'DetailKerjasamaController@index')->name('detailKerjasama');


Route::get('/kerjasamaRekrutmen', 'PengajuanKerjasamaController@showKerjaSamaUpkk')->name('kerjasamaRekrutmenUpkk');
Route::post('/konfirmasiKerjasama/confirm/{id}', 'PengajuanKerjasamaController@terimaKerjasama')->name('terimaKerjasama');
Route::post('/konfirmasiKerjasama/cancel/{id}', 'PengajuanKerjasamaController@tolakKerjasama')->name('tolakKerjasama');


// Route::get('userProfile/{user}',  ['as' => 'users.edit', 'uses' => 'UserProfileController@sendUserData']);
// Route::patch('userProfile/{user}/update',  ['as' => 'users.update', 'uses' => 'UpdateProfileController@updateUserData']);