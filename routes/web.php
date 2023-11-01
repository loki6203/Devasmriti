<?php

use Illuminate\Support\Facades\Route;

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
Route::post('/ccavenue/requestHandler.php', 'API\OrderController@requestHandler');
Route::get('/ccavenue/requestHandler/{order_id}/{isTesting}', 'API\OrderController@requestHandler');
Route::get('/ccavenue/payment.php','API\OrderController@payment');
Route::post('/ccavenue/responseHandler.php','API\OrderController@responseHandler');