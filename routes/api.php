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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});


//APIS
//1. get all practitioners API
Route::get('/json/practitioners', 'APIController@index');
//get one practitioner by practitioner->id and renewal status
Route::get('/json/practitioners/{practitioner}', 'APIController@show');
//get practitioner by registration_number and Id_number
Route::get('/json/practitioners/{registration_number}/{id_number}', 'APIController@byRegID');

//get practitioner by registration_number string and Id_number
Route::get('/json/practitioner_string/{registration_number}/{id_number}', 'APIController@byRegIdString');

Route::get('/json/testing/{registration_number}/{id_number}', 'APIController@test');

Route::get('/json/test', 'APIController@test');
