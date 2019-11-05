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

// Categories
Route::get('/categories','Api\CategoryController@index');
Route::get('/categories/{id}','Api\CategoryController@show');

// Products
Route::get('/products','Api\ProductController@index');
