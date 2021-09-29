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
Route::get('/contact_us', 'API\CmsController@contact_us');
Route::get('/countries', 'API\CmsController@countries');
Route::get('/states', 'API\CmsController@states');
Route::get('/cities', 'API\CmsController@cities');
Route::get('/state_based_on_country/{country_id}', 'API\CmsController@state_based_on_country');
Route::get('/city_based_on_country_and_state/{country_id}/{state_id}', 'API\CmsController@city_based_on_country_and_state');
Route::middleware('json')->group(function(){
    Route::post('/login',        'JWTAuthController@login');
    Route::post('/signup',       'JWTAuthController@signup');
    Route::post('/resend_otp', 'API\UserController@resend_otp')->middleware('json');
    Route::post('/Check_Otp', 'API\UserController@Check_Otp')->middleware('json');
    Route::post('/Otp_Verification', 'API\UserController@Otp_Verification')->middleware('json');
    Route::post('/forgot_password', 'API\UserController@forgot_password')->middleware('json');
});
Route::middleware('jwt')->group(function(){
    Route::post('/logout',       'JWTAuthController@logout');
    Route::post('/refresh',      'JWTAuthController@refresh');
    Route::get('/user_details',  'JWTAuthController@user_details');
    Route::post('/user_change_password', 'API\UserController@user_change_password')->middleware('json');
    Route::post('/add_or_change_tpin', 'API\UserController@add_or_change_tpin')->middleware('json');
    Route::get('/check_tpin_generated_or_not', 'API\UserController@check_tpin_generated_or_not');
    Route::get('/check_pan_adhar_tpin_status', 'API\UserController@check_pan_adhar_tpin_status');
    Route::get('/check_tpin_valid_or_not/{tpin}', 'API\UserController@check_tpin_valid_or_not');
    Route::post('/update_contact_details', 'API\UserController@update_contact_details')->middleware('json');
    Route::get('/verify_adhar_or_resend_otp/{adharnumber}', 'API\UserController@verify_adhar_or_resend_otp');
    Route::get('/verify_pan/{pannumber}', 'API\UserController@verify_pan');
    Route::post('/submit_adhar_with_otp', 'API\UserController@submit_adhar_with_otp')->middleware('json');
    Route::post('/internal_transfer_Search', 'API\InternalController@internal_transfer_Search')->middleware('json');
    Route::get('/int_trnsf_individual_history/{user_id}', 'API\InternalController@int_trnsf_individual_history');
    Route::get('/int_trnsf_all_history', 'API\InternalController@int_trnsf_all_history');
    Route::post('/int_trnsf_amount_paying', 'API\InternalController@int_trnsf_amount_paying')->middleware('json');
    Route::post('/check_wallet_amount', 'API\InternalController@check_wallet_amount')->middleware('json');
    Route::post('/deposit_money_to_account', 'API\RechargeController@deposit_money_to_account')->middleware('json');
    Route::post('/deposit_money_to_payment_status', 'API\RechargeController@deposit_money_to_payment_status')->middleware('json');
    Route::post('/recharge_payment', 'API\RechargeController@recharge_payment')->middleware('json');
    Route::get('/payment_history', 'API\RechargeController@payment_history');
});
Route::post('/upload_photo', 'API\UserController@upload_photo');