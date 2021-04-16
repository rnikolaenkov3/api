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

//Route::middleware('auth:api')->get('/user', function (Request $request) {
//    return $request->user();
//});

Route::prefix('v1')
    ->namespace('App\Http\Controllers\Api\V1')
    ->name('api_v1.')
    ->group(function() {
        Route::get('/', 'ProductController@getProducts')->name('product.getProducts');
        Route::get('/{id}', 'ProductController@getProductById')->name('product.getProductById');
        Route::post('/products/create', 'ProductController@create')->name('product.create');
        Route::put('/products/update/{id}', 'ProductController@update')->name('product.update');
        Route::delete('/products/delete/{id}', 'ProductController@delete')->name('product.delete');
    });
