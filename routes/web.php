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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
Route::prefix('/admin')->group(function() {
    Route::get('/login', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login');
    Route::post('/login', 'AuthAdmin\AdminLoginController@login')->name('admin.submit');

    Route::post('/logout', 'AuthAdmin\AdminLoginController@logout')->name('admin.logout');
    Route::get('/home', 'AdminController@index')->name('admin.home');

    Route::get('/movies', 'MovieController@index')->name('admin.movies');

    Route::get('/movies', 'MovieController@index')->name('admin.movies');

    
    Route::get('/movie/list', 'MovieController@list')->name('list.key');

    Route::post('/movie/store', 'MovieController@store');
    Route::delete('/movie/{id}', 'MovieController@delete');

});

