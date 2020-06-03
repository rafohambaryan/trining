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
        'login' => false,
        'password.request' => false,
    ]);
    Route::get('/admin', 'Auth\LoginController@showLoginForm')->name('login');
    Route::post('/admin', 'Auth\LoginController@login');
    Route::group(['prefix' => 'admin', 'namespace' => 'Backend'], function () {
        Route::get('/dashboard', 'HomeController@index');
        Route::get('/films', 'FilmController@films');
        Route::get('/hall', 'HallController@index');
        Route::get('/films/{id}', 'HomeController@get');
        Route::post('/films/{id?}', 'HomeController@createOrUpdate');
        Route::delete('/films/delete', 'HomeController@deleted');
    });
});
Route::any('{error}', function ($page) {
    abort(404);
});
