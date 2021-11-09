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

Route::get('/', 'Admin\SuperadminController@index');
Route::get('/dashboard', 'Admin\SuperadminController@dashboard');
Route::get('/admin_management', 'Admin\SuperadminController@admin_management');
Route::get('/user_management', 'Admin\SuperadminController@user_management');
Route::get('/add_admin', 'Admin\SuperadminController@add_admin');
Route::get('/add_user', 'Admin\SuperadminController@add_user');
Route::get('/edit_user/{id}', 'Admin\SuperadminController@edit_user');
Route::get('/update_user/{id}', 'Admin\SuperadminController@update_user');
Route::get('/edit_admin/{id}', 'Admin\SuperadminController@edit_admin');
Route::get('/update_admin/{id}', 'Admin\SuperadminController@update_admin');
Route::get('/edit_user', 'Admin\SuperadminController@edit_user');
Route::get('/password_recovery', 'Admin\SuperadminController@password_recovery');
Route::get('/user_tpin_change', 'Admin\SuperadminController@user_tpin_change');
Route::get('/user_transactions', 'Admin\SuperadminController@user_transactions');
Route::get('/payment_gateway_management', 'Admin\SuperadminController@payment_gateway_management');
Route::get('/wallet_management', 'Admin\SuperadminController@wallet_management');
Route::get('/referral_management', 'Admin\SuperadminController@referral_management');
Route::get('/support', 'Admin\SuperadminController@support');
Route::get('/transactions', 'Admin\SuperadminController@transactions');
Route::get('/referral', 'Admin\SuperadminController@referral');
Route::get('/country', 'Admin\SuperadminController@country');
Route::get('/state', 'Admin\SuperadminController@state');
Route::get('/city', 'Admin\SuperadminController@city');