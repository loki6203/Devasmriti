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
Route::get('/edit_admin', 'Admin\SuperadminController@edit_admin');
Route::get('/edit_user', 'Admin\SuperadminController@edit_user');
Route::get('/password_recovery', 'Admin\SuperadminController@password_recovery');
Route::get('/user_tpin_change', 'Admin\SuperadminController@user_tpin_change');
Route::get('/user_transactions', 'Admin\SuperadminController@user_transactions');
Route::get('/payment_gateway_management', 'Admin\SuperadminController@payment_gateway_management');

