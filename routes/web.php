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
Route::get('/profile/{username}','UserProfileController@userData')->name('profile');
Route::get('/profile/edit/{id}','UserProfileController@sendUserData')->name('profile.edit');
Route::post('/profile/update','UserProfileController@update');

// Route::get('userProfile/{user}',  ['as' => 'users.edit', 'uses' => 'UserProfileController@sendUserData']);
// Route::patch('userProfile/{user}/update',  ['as' => 'users.update', 'uses' => 'UpdateProfileController@updateUserData']);