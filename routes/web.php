<?php

use Illuminate\Support\Facades\Auth;
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
// Auth::routes();

Route::get('/', 'Admin\SuperadminController@index');
Route::get('/login', 'Admin\SuperadminController@index');
Route::get('/index', 'Admin\SuperadminController@index')->name('index');
Route::post('/check_login', 'Admin\SuperadminController@check_login');

Route::group(array('middleware' => 'validSuperadmin'), function(){
    Route::get('/logout', 'Admin\SuperadminController@logout');
    Route::get('/dashboard', 'Admin\SuperadminController@dashboard');
    Route::get('/admin_management', 'Admin\SuperadminController@admin_management');
    Route::get('/user_management', 'Admin\SuperadminController@user_management');
    Route::get('/add_admin', 'Admin\SuperadminController@add_admin');
    Route::get('/add_user', 'Admin\SuperadminController@add_user');
    Route::get('/edit_user/{id}', 'Admin\SuperadminController@edit_user');
    Route::post('/update_user/{id}', 'Admin\SuperadminController@update_user');
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
    Route::post('/save_user', 'Admin\SuperadminController@save_user');
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

    Route::get('/rasi', 'Admin\SuperadminController@rasi');
    Route::get('/add_rasi', 'Admin\SuperadminController@add_rasi');
    Route::get('/save_rasi', 'Admin\SuperadminController@save_rasi');
    Route::get('/edit_rasi/{id}', 'Admin\SuperadminController@edit_rasi');
    Route::get('/update_rasi/{id}', 'Admin\SuperadminController@update_rasi');
    Route::get('/change_rasi_status/{id}/{status}', 'Admin\SuperadminController@change_rasi_status');

    Route::get('/temple', 'Admin\SuperadminController@temple');
    Route::get('/add_temple', 'Admin\SuperadminController@add_temple');
    Route::post('/save_temple', 'Admin\SuperadminController@save_temple');
    Route::get('/edit_temple/{id}', 'Admin\SuperadminController@edit_temple');
    Route::post('/update_temple/{id}', 'Admin\SuperadminController@update_temple');
    Route::get('/change_temple_status/{id}/{status}', 'Admin\SuperadminController@change_temple_status');

    Route::get('/user_family/{user_id}/{id?}', 'Admin\SuperadminController@user_family');
    Route::get('/change_family_status/{id}/{status}/{user_id}', 'Admin\SuperadminController@change_family_status');
    Route::post('/save_family/{user_id}', 'Admin\SuperadminController@save_family');

    Route::get('/user_address/{user_id}/{id?}', 'Admin\SuperadminController@user_address');
    Route::get('/change_address_status/{id}/{status}/{user_id}', 'Admin\SuperadminController@change_address_status');
    Route::post('/save_address/{user_id}', 'Admin\SuperadminController@save_address');

    Route::get('/relation', 'Admin\SuperadminController@relation');
    Route::get('/add_relation', 'Admin\SuperadminController@add_relation');
    Route::get('/save_relation', 'Admin\SuperadminController@save_relation');
    Route::get('/edit_relation/{id}', 'Admin\SuperadminController@edit_relation');
    Route::get('/update_relation/{id}', 'Admin\SuperadminController@update_relation');
    Route::get('/change_relation_status/{id}/{status}', 'Admin\SuperadminController@change_relation_status');

    Route::get('/seva', 'Admin\SuperadminController@seva');
    Route::get('/add_seva', 'Admin\SuperadminController@add_seva');
    Route::post('/save_seva', 'Admin\SuperadminController@save_seva');
    Route::get('/edit_seva/{id}', 'Admin\SuperadminController@edit_seva');
    Route::post('/update_seva/{id}', 'Admin\SuperadminController@update_seva');
    Route::get('/change_seva_status/{id}/{status}', 'Admin\SuperadminController@change_seva_status');

    Route::get('/order', 'Admin\SuperadminController@order');
    Route::get('/order_old', 'Admin\SuperadminController@order_old');
    Route::get('/export_order', 'Admin\SuperadminController@export_order');
});
