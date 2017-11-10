<?php

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

Route::get('auth/{socialServiceName}', 'Auth\SocialController@redirectToSocialService');
Route::get('auth/{socialServiceName}/callback', 'Auth\SocialController@handleSocialServiceCallback');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
