<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
URL::forceScheme('https');
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
    Route::post('/user/profile', 'API\UserController@profile_update');


    Route::post('/states', 'API\StateController@index')->middleware('json')->withoutMiddleware('jwt');
    Route::get('/states', 'API\StateController@index')->withoutMiddleware('jwt');
    Route::get('/states/{id}', 'API\StateController@index')->withoutMiddleware('jwt');
    Route::put('/states/{id}', 'API\StateController@index')->middleware('json')->withoutMiddleware('jwt');
    Route::delete('/states/{id}', 'API\StateController@index')->withoutMiddleware('jwt');
    
    Route::post('/city', 'API\CityController@index')->middleware('json')->withoutMiddleware('jwt');
    Route::get('/city', 'API\CityController@index')->withoutMiddleware('jwt');
    Route::get('/city/{id}', 'API\CityController@index')->withoutMiddleware('jwt');
    Route::put('/city/{id}', 'API\CityController@index')->middleware('json')->withoutMiddleware('jwt');
    Route::delete('/city/{id}', 'API\CityController@index')->withoutMiddleware('jwt');
    
    Route::post('/address', 'API\UserAddressController@index')->middleware('json');
    Route::get('/address', 'API\UserAddressController@index');
    Route::get('/address/{id}', 'API\UserAddressController@index');
    Route::put('/address/{id}', 'API\UserAddressController@index')->middleware('json');
    Route::delete('/address/{id}', 'API\UserAddressController@index');
    
    Route::post('/myfamily', 'API\UserFamilyDetailController@index')->middleware('json');
    Route::get('/myfamily', 'API\UserFamilyDetailController@index');
    Route::get('/myfamily/{id}', 'API\UserFamilyDetailController@index');
    Route::put('/myfamily/{id}', 'API\UserFamilyDetailController@index')->middleware('json');
    Route::delete('/myfamily/{id}', 'API\UserFamilyDetailController@index');

    Route::get('/rasi', 'API\RasiController@index')->withoutMiddleware('jwt');
    Route::get('/rasi/{id}', 'API\RasiController@index')->withoutMiddleware('jwt');

    Route::get('/anouncement', 'API\AnouncementController@index')->withoutMiddleware('jwt');
    Route::get('/anouncement/{id}', 'API\AnouncementController@index')->withoutMiddleware('jwt');

    Route::get('/relation', 'API\RelationController@index')->withoutMiddleware('jwt');
    Route::get('/relation/{id}', 'API\RelationController@index')->withoutMiddleware('jwt');

    Route::get('/home/banners', 'API\BannerController@index')->withoutMiddleware('jwt');
    Route::get('/home/banners/{id}', 'API\BannerController@index')->withoutMiddleware('jwt');

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
    
    Route::get('/seva/faqs/{seva_d}', 'API\SevaFaqController@index')->withoutMiddleware('jwt');
    Route::get('/seva/faqs/{seva_d}/{id}', 'API\SevaFaqController@index')->withoutMiddleware('jwt');

    Route::get('/event/faqs/{event_id}', 'API\EventFaqController@index')->withoutMiddleware('jwt');
    Route::get('/event/faqs/{event_id}/{id}', 'API\EventFaqController@index')->withoutMiddleware('jwt');

    Route::post('/cart', 'API\UserCartController@index')->middleware('json')->withoutMiddleware('jwt');
    Route::get('/cart', 'API\UserCartController@index');
    Route::get('/cart/{id}', 'API\UserCartController@index');
    Route::put('/cart/{id}', 'API\UserCartController@index')->middleware('json');
    Route::delete('/cart/{id}', 'API\UserCartController@index');

    Route::get('/coupons', 'API\SevaCouponController@index')->withoutMiddleware('jwt');
    Route::get('/coupons/{id}', 'API\SevaCouponController@index')->withoutMiddleware('jwt');
    Route::get('/checkCoupon/{code}', 'API\SevaCouponController@checkCoupon')->withoutMiddleware('jwt');

    Route::post('/bookings', 'API\OrderController@index')->middleware('json');
    Route::get('/bookings', 'API\OrderController@index');
    Route::get('/bookings/{id}', 'API\OrderController@index');
    Route::put('/bookings/{id}', 'API\OrderController@index')->middleware('json');

    Route::post('/file/upload', 'API\ImageController@index')->withoutMiddleware('jwt');
    Route::post('/payment_checksum', 'API\OrderController@payment_checksum')->withoutMiddleware('jwt');
});
// Route::get('/ccavenue/requestHandler/{order_id}', 'API\OrderController@requestHandler');
// Route::post('/ccavenue/requestHandler','API\OrderController@requestHandler');
Route::get('/ccavenue/payment/{order_id}','API\OrderController@requestHandler');
Route::post('/ccavenue/responseHandler','API\OrderController@responseHandler');