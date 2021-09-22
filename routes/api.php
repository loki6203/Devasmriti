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
Route::post('/forgot_password', 'API\UserController@forgot_password');
Route::get('/countries', 'API\CmsController@countries'); ##
Route::get('/states', 'API\CmsController@states'); ##
Route::get('/cities', 'API\CmsController@cities'); ##
Route::get('/state_based_on_country/{country_id}', 'API\CmsController@state_based_on_country'); ##
Route::get('/city_based_on_country_and_state/{country_id}/{state_id}', 'API\CmsController@city_based_on_country_and_state'); ##

Route::middleware('auth:api')->group(function(){
    Route::post('/user_change_password', 'API\UserController@user_change_password');
    Route::get('/check_pan_adhar_tpin_status', 'API\UserController@check_pan_adhar_tpin_status');
    Route::post('/add_or_change_tpin', 'API\UserController@add_or_change_tpin');
    Route::get('/check_tpin_valid_or_not/{tpin}', 'API\UserController@check_tpin_valid_or_not');
    Route::get('/verify_adhar_or_resend_otp/{adharnumber}', 'API\UserController@verify_adhar_or_resend_otp');
    Route::get('/verify_pan/{pannumber}', 'API\UserController@verify_pan');
    Route::post('/submit_adhar_with_otp', 'API\UserController@submit_adhar_with_otp');
    Route::post('/upload_photo', 'API\UserController@upload_photo'); ##
    Route::post('/update_contact_details', 'API\UserController@update_contact_details'); ##
    Route::get('/user_details', 'API\UserController@user_details'); ##
    Route::post('/internal_transfer_Search', 'API\InternalController@internal_transfer_Search');
    Route::get('/int_trnsf_individual_history/{user_id}', 'API\InternalController@int_trnsf_individual_history');
    Route::get('/int_trnsf_all_history', 'API\InternalController@int_trnsf_all_history');
    Route::post('/int_trnsf_amount_paying', 'API\InternalController@int_trnsf_amount_paying');
    Route::post('/check_wallet_amount', 'API\InternalController@check_wallet_amount');
    Route::post('/deposit_money_to_account', 'API\RechargeController@deposit_money_to_account');
    Route::post('/deposit_money_to_payment_status', 'API\RechargeController@deposit_money_to_payment_status');
    Route::post('/recharge_payment', 'API\RechargeController@recharge_payment');

    Route::get('/payment_history', 'API\RechargeController@payment_history');  ###
});
