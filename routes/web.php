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
    Route::post('/checked', 'CheckedController@checked');
    Auth::routes([
        'register' => false,
        'login' => false,
        'password.request' => false,
        'password.email' => false,
    ]);
    Route::get('/admin', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/admin', 'Auth\LoginController@login');
    Route::group(['prefix' => 'admin', 'namespace' => 'Backend', 'middleware' => 'auth'], function () {
        Route::get('/dashboard', 'HomeController@index');


        Route::get('/films', 'FilmController@films');
        Route::get('/card/{code}', 'CheckedController@getCard')->where('code', '[A-Za-z0-9]+');
        Route::delete('/card/{code}', 'CheckedController@deleteCard')->where('code', '[A-Za-z0-9]+');
        Route::get('/films/{id}', 'FilmController@find');
        Route::post('/films/{id?}', 'FilmController@createOrUpdate');
        Route::delete('/films/delete', 'FilmController@deleted');


        Route::get('/hall', 'HallController@index');

        Route::post('/get-checked', 'CheckedController@getChecked');
    });
});


Route::fallback(function () {
    abort(404);
});
