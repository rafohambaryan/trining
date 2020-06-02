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

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

Route::group(['middleware' => 'throttle:60,1'], function () {
    Route::get('/', 'FilmController@index');
    Route::post('/', 'FilmController@getFilm');
    Route::post('/date', 'FilmController@getFilmDate');
    Route::post('/checked', 'FilmController@checked');
    Auth::routes([
        'register' => false,
        'login' => false
    ]);
    Route::group(['prefix' => 'admin'], function () {
        Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
        Route::post('/', 'Auth\LoginController@login');
        Route::get('/dashboard', 'Backend\HomeController@index');
        Route::get('/films', 'Backend\HomeController@films');
        Route::post('/films/{id?}', 'Backend\HomeController@createOrUpdate');
    });
});
Route::any('{error}', function ($page) {
    abort(404);
});
