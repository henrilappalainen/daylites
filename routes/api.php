<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::get('cities', "CitiesController@index"); // List Cities
Route::post('cities', "CitiesController@store"); // Create City
Route::get('daylites/?latitude', "DaylitesController@index"); // Get Daylight data

// Route::get('posts', "PostController@index"); // List Posts
// Route::post('posts', "PostController@store"); // Create Post
// Route::delete('posts/{id}', "PostController@destroy"); // Delete Post