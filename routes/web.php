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
Route::get('/change_admin_status/{id}/{status}/{type}', 'Admin\SuperadminController@change_admin_status');
Route::get('/save_admin', 'Admin\SuperadminController@save_admin');
Route::get('/save_user', 'Admin\SuperadminController@save_user');
Route::get('/change_country_status/{id}/{status}', 'Admin\SuperadminController@change_country_status');
Route::get('/add_country', 'Admin\SuperadminController@add_country');
Route::get('/save_country', 'Admin\SuperadminController@save_country');
Route::get('/edit_country/{id}', 'Admin\SuperadminController@edit_country');
Route::get('/update_country/{id}', 'Admin\SuperadminController@update_country');
Route::get('/add_state', 'Admin\SuperadminController@add_state');
Route::get('/save_state', 'Admin\SuperadminController@save_state');
Route::get('/edit_state/{id}', 'Admin\SuperadminController@edit_state');
Route::get('/update_state/{id}', 'Admin\SuperadminController@update_state');
Route::get('/change_state_status/{id}/{status}', 'Admin\SuperadminController@change_state_status');
Route::get('/add_city', 'Admin\SuperadminController@add_city');
Route::get('/save_city', 'Admin\SuperadminController@save_city');
Route::get('/edit_city/{id}', 'Admin\SuperadminController@edit_city');
Route::get('/update_city/{id}', 'Admin\SuperadminController@update_city');
Route::get('/change_city_status/{id}/{status}', 'Admin\SuperadminController@change_city_status');
Route::post('/get_states', 'Admin\SuperadminController@get_states');
Route::get('/change_password', 'Admin\SuperadminController@change_password');
Route::get('/update_password', 'Admin\SuperadminController@update_password');
Route::get('/check_login', 'Admin\SuperadminController@check_login');
Route::get('/logout', 'Admin\SuperadminController@logout');