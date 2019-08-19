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

 Route::post('/signin', 'UserController@userLogin');
 Route::post('/signup', 'UserController@userRegister');

 Route::get('/location/{id?}', 'LocationController@index');
 Route::get('/category/{id?}', 'CategoryController@index');

 Route::get('/product/list', 'ProductController@list');
 Route::get('/product/item/{id}', 'ProductController@item');

 Route::get('/contact', 'ProductController@contact');
 Route::post('/make_order','OrderController@store');
 Route::get('/slider','SliderController@list');

 Route::group(['middleware' => 'auth:api'], function(){

Route::get('/details', 'UserController@userDetails');

     
//     Route::post('/estate/create', 'EstateController@store');
//     Route::get('/estate/delete/{id}', 'EstateController@delete');
//
//     Route::post('/vehicle/create', 'VehicleController@store');
//     Route::get('/vehicle/delete/{id}', 'VehicleController@delete');
//
//     Route::get('/Product/delete/{id}', 'ProductController@delete');
//     Route::post('/Product/create', 'ProductController@store');
 });



// /api/Product/<main category id>/?subcategory=<3>&locationP=<location id>&locatinC
// Route::get('/estate/list', 'EstateController@list');
// Route::get('/estate/item/{id}', 'EstateController@item');

// Route::get('/vehicle/list', 'VehicleController@list');
// Route::get('/vehicle/item/{id}', 'VehicleController@item');
