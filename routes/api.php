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


Route::group(['prefix' => 'auth'], function () {
    Route::post('/login', 'AuthController@login');
    Route::post('/register', 'AuthController@register');
    Route::post('/logout', 'AuthController@logout');
});



Route::group(['middleware' => 'auth.jwt'], function () {
    Route::get('/offerings', 'OfferingController@index');
    Route::get('/offerings/{id}', 'OfferingController@show');
    Route::post('/offerings/new/', 'OfferingController@store');
    Route::put('/offerings/{id}', 'OfferingController@update');
    Route::delete('/offerings/{id}', 'OfferingController@destroy');

    Route::get('/purchases', 'PurchaseController@index');
    Route::get('/purchases/{id}', 'PurchaseController@show');
    Route::post('/purchases/new/', 'PurchaseController@store');
    Route::put('/purchases/{id}', 'PurchaseController@update');
    Route::delete('/purchases/{id}', 'PurchaseController@destroy');
});
