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
Route::get('/add_admin', 'Admin\SuperadminController@add_admin');
Route::get('/edit_admin', 'Admin\SuperadminController@edit_admin');
