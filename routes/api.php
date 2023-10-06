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
    Route::put('/user/profile', 'API\UserController@profile_update')->middleware('json');
    Route::get('/user/profile', 'API\UserController@profile_update');
    Route::post('/user/post', 'API\UserController@profile_update');


    Route::post('/states', 'API\StateController@states')->middleware('json')->withoutMiddleware('jwt');
    Route::get('/states', 'API\StateController@states')->withoutMiddleware('jwt');
    Route::get('/states/{id}', 'API\StateController@states')->withoutMiddleware('jwt');
    Route::put('/states/{id}', 'API\StateController@states')->middleware('json')->withoutMiddleware('jwt');
    Route::delete('/states/{id}', 'API\StateController@states')->withoutMiddleware('jwt');
    
    Route::post('/city', 'API\CityController@cities')->middleware('json');
    Route::get('/city', 'API\CityController@cities')->withoutMiddleware('jwt');
    Route::get('/city/{id}', 'API\CityController@cities');
    Route::put('/city/{id}', 'API\CityController@cities')->middleware('json');
    Route::delete('/city/{id}', 'API\CityController@cities');
    
    Route::post('/address', 'API\UserAddress@address')->middleware('json');
    Route::get('/address', 'API\UserAddress@address');
    Route::get('/address/{id}', 'API\UserAddress@address');
    Route::put('/address/{id}', 'API\UserAddress@address')->middleware('json');
    Route::delete('/address/{id}', 'API\UserAddress@address');
    
    Route::post('/myfamily', 'API\UserFamilyDetailController@myfamily')->middleware('json');
    Route::get('/myfamily', 'API\UserFamilyDetailController@myfamily');
    Route::get('/myfamily/{id}', 'API\UserFamilyDetailController@myfamily');
    Route::put('/myfamily/{id}', 'API\UserFamilyDetailController@myfamily')->middleware('json');
    Route::delete('/myfamily/{id}', 'API\UserFamilyDetailController@myfamily');

    Route::get('/rasi', 'API\RasiController@index')->withoutMiddleware('jwt');
    Route::get('/rasi/{id}', 'API\RasiController@index')->withoutMiddleware('jwt');

    Route::get('/relation/faqs', 'API\RelationController@index')->withoutMiddleware('jwt');
    Route::get('/relation/{id}', 'API\RelationController@index')->withoutMiddleware('jwt');

    Route::get('/home/faqs', 'API\FaqController@index')->withoutMiddleware('jwt');
    Route::get('/home/faqs/{id}', 'API\FaqController@index')->withoutMiddleware('jwt');

    Route::get('/home/testimonials', 'API\TestimonialController@index')->withoutMiddleware('jwt');
    Route::get('/home/testimonials/{id}', 'API\TestimonialController@index')->withoutMiddleware('jwt');

    Route::get('/temples', 'API\TempleController@index')->withoutMiddleware('jwt');
    Route::get('/temples/{id}', 'API\TempleController@index')->withoutMiddleware('jwt');

    Route::get('/seva_types', 'API\SevaTypeController@index')->withoutMiddleware('jwt');
    Route::get('/seva_types/{id}', 'API\SevaTypeController@index')->withoutMiddleware('jwt');

    Route::get('/sevas', 'API\SevaController@index')->withoutMiddleware('jwt');
    Route::get('/sevas/{id}', 'API\SevaController@index')->withoutMiddleware('jwt');

    Route::get('/seva_options/{seva_id}', 'API\SevaPriceController@index')->withoutMiddleware('jwt');
    Route::get('/seva_options/{seva_id}/{id}', 'API\SevaPriceController@index')->withoutMiddleware('jwt');

    Route::get('/events', 'API\EventSevaController@index')->withoutMiddleware('jwt');
    Route::get('/events/{id}', 'API\EventSevaController@index')->withoutMiddleware('jwt');
    
});