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
Route::middleware('jwt')->group(function(){
    Route::post('/user/login', 'API\UserController@login_signup')->middleware('json')->withoutMiddleware('jwt');
    Route::post('/user/login_with_otp', 'API\UserController@login_with_otp')->middleware('json')->middleware('json')->withoutMiddleware('jwt');
});
