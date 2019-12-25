<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/v1')->group(function() {
 Route::get('/movie/data', 'MovieController@data')->name('list.data.api');
 		

 Route::get('/post/data', 'PostController@data')->name('post.api');


// get list comment for id video.
 // http://localhost:8000/api/v1/movie/{1}
 Route::get('/movie/{id}', 'MovieController@get')->name('get.moive');



});
