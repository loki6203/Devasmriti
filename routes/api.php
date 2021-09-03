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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
Route::post('/login', 'API\UserController@login');
Route::post('/signup', 'API\UserController@signup');
Route::post('/resend_otp', 'API\UserController@resend_otp');
Route::post('/Check_Otp', 'API\UserController@Check_Otp');
Route::post('/Otp_Verification', 'API\UserController@Otp_Verification');
Route::get('/contact_us', 'API\UserController@contact_us');

Route::middleware('auth:api')->group(function () {
    Route::post('/user_change_password', 'API\UserController@user_change_password');
    Route::get('/check_pan_adhar_tpin_status', 'API\UserController@check_pan_adhar_tpin_status');
});
