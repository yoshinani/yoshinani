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

Route::get('/', function ()
{
    return view('welcome');
});

Route::group(['middleware' => 'guest'], function ()
{
    Route::get('login', 'Auth\ManualController@loginEdit')->name('login');
    Route::post('login', 'Auth\ManualController@login');

    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('password.email');
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('password.request');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('password.reset');

    Route::get('register', 'Auth\ManualController@registerEdit')->name('register');
    Route::post('register/confirmation', 'Auth\ManualController@confirmationRegister')->name('confirmationRegister');
    Route::post('register/complete', 'Auth\ManualController@completeRegister')->name('completeRegister');

    if (config('configuration.socialite')) {
        Route::get('auth/{driverName}', 'Auth\SocialController@redirectToProvider');
        Route::get('auth/{driverName}/callback', 'Auth\SocialController@handleProviderCallback');
    }
});

Route::group(['middleware' => 'auth'], function ()
{
    Route::get('/home', 'HomeController@index')->name('home');

    Route::get('/home/user', 'Home\UserController@index')->name('home.user');
    Route::get('/home/user/withdrawal', 'Home\UserController@withdrawal')->name('home.user.withdrawal');
});

Route::post('logout', 'Auth\ManualController@logout')->name('logout');
