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
    Route::post('/add_or_change_tpin', 'API\UserController@add_or_change_tpin');
    Route::get('/check_tpin_valid_or_not/{tpin}', 'API\UserController@check_tpin_valid_or_not');
    Route::post('/internal_transfer_Search', 'API\InternalController@internal_transfer_Search');
    Route::get('/int_trnsf_individual_history/{user_id}', 'API\InternalController@int_trnsf_individual_history');
    Route::get('/int_trnsf_all_history', 'API\InternalController@int_trnsf_all_history');
    Route::post('/int_trnsf_amount_paying', 'API\InternalController@int_trnsf_amount_paying');
    Route::post('/check_wallet_amount', 'API\InternalController@check_wallet_amount');
    Route::post('/add_money_to_wallet', 'API\RechargeController@add_money_to_wallet');
});
