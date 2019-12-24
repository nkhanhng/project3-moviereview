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

Route::get('/', function(){return view('welcome');})->name('login');

Auth::routes();



Route::prefix('/admin')->group(function() {


	Route::get('/', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login');
	Route::get('/login', 'AuthAdmin\AdminLoginController@showLoginForm')->name('admin.login');
	Route::post('/login', 'AuthAdmin\AdminLoginController@login')->name('admin.submit');
});



Route::prefix('/admin')->group(function() {

	Route::get('/home', 'AdminController@index')->name('admin.home');
	Route::get('/movies', 'AdminController@index')->name('admin.movies');
	Route::get('/movie/list', 'AdminController@list')->name('admin.list.key');
	Route::post('/movie/status', 'AdminController@status')->name('admin.status');
	Route::delete('/movie/{id}', 'AdminController@delete');
	Route::post('/logout', 'AuthAdmin\AdminLoginController@logout')->name('admin.logout');


	Route::get('/posts', 'AdminPostController@index');
	Route::get('/post/get/{id}', 'AdminPostController@getPost');
	Route::get('/post/status/{id}', 'AdminPostController@setStatus');
	Route::get('/post/lists', 'AdminPostController@anyData');
	Route::post('/post/store', 'AdminPostController@store');
	Route::post('/post/update', 'AdminPostController@update');
	Route::delete('/post/{id}', 'AdminPostController@delete');
});




Route::middleware('auth')->prefix('/')->group(function() {


	Route::get('/home', 'MovieController@index')->name('home');
	Route::get('/movies', 'MovieController@index')->name('movies');
	Route::get('/movie/list', 'MovieController@list')->name('list.key');
	Route::post('/movie/store', 'MovieController@store');
	Route::delete('/movie/{id}', 'MovieController@delete');



	Route::get('/posts', 'PostController@index')->name('posts');
	Route::get('/post/get/{id}', 'PostController@getPost')->name('posts.details');
	Route::get('/post/lists', 'PostController@anyData')->name('posts.data');
	Route::post('/post/store', 'PostController@store');
	Route::post('/post/update', 'PostController@update');
	Route::delete('/post/{id}', 'PostController@delete');


 	
});
Route::get('/api/v1/user', 'HomeController@user')->name('get.user');