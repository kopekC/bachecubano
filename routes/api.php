<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
| Within this group, the `/api` URI prefix is automatically applied so you do not need to manually apply it to every route in the file
|
*/

//MailGun Routes WebHook for LaChopi Incoming Requests
/*
Route::group(['prefix' => 'mailgun',], function () {
    Route::post('widgets', 'MailgunWidgetsController@store');
});
*/

//SubDomain Mapping
Route::group(['domain' => 'api.bachecubano.com'], function () {
    Route::group(['prefix' => 'v1'], function () {
        //Get Categories
        Route::get('categories', 'Api\AdsController@get_categories')->name('api_get_categories');
        //Get Ads From certain Category
        Route::get('ads/{category_id}', 'Api\AdsController@get_ads')->name('api_get_ads');
        //Get Specific Ad
        Route::get('ad/{ad_id}', 'Api\AdsController@get_ad')->name('api_get_ad');
        //Sitemap Creator
        Route::get('sitemap', 'Api\SitemapController@sitemap_index')->name('sitemap_index');
        //Search model
        Route::get('search', 'Api\AdsController@search')->name('api_search');
        //Like/Dislike behavior
        Route::get('ad_like/{ad}', 'Api\LikeController@ad_like')->name('ad_like')->middleware('auth:api');
        //Like/Dislike behavior
        Route::get('ad_dislike/{ad}', 'Api\LikeController@ad_dislike')->name('ad_dislike')->middleware('auth:api');
        //Like/Dislike behavior
        Route::get('ad_hit_like/{ad}', 'Api\LikeController@ad_hit_like')->name('ad_hit_like')->middleware('auth:api');
    });
});

//Version 1.0 API This has to be remved when go to production Just Testing Here at localhost
Route::group(['prefix' => 'v1'], function () {
    //Get Categories
    Route::get('categories', 'Api\AdsController@get_categories')->name('api_get_categories');
    //Get Ads From certain Category
    Route::get('ads/{category_id}', 'Api\AdsController@get_ads')->name('api_get_ads');
    //Get Specific Ad
    Route::get('ad/{ad_id}', 'Api\AdsController@get_ad')->name('api_get_ad');
    //Mailable View
    Route::get('mailable', 'Api\MailableController@view');
    //Sitemap Creator
    Route::get('sitemap', 'Api\SitemapController@sitemap_index')->name('sitemap_index');
    //Search model
    Route::get('search', 'Api\AdsController@search')->name('api_search');
    //Like/Dislike behavior
    Route::get('ad_like/{ad}', 'Api\LikeController@ad_like')->name('ad_like')->middleware('auth:api');
    //Like/Dislike behavior
    Route::get('ad_dislike/{ad}', 'Api\LikeController@ad_dislike')->name('ad_dislike')->middleware('auth:api');
    //Like/Dislike behavior
    Route::get('ad_hit_like/{ad}', 'Api\LikeController@ad_hit_like')->name('ad_hit_like')->middleware('auth:api');
});

//Passport Routes for login/signup/logout/getUser
Route::group(['prefix' => 'auth'], function () {
    Route::group(['middleware' => ['guest:api']], function () {
        Route::post('login', 'Api\AuthController@login');
        Route::post('signup', 'Api\AuthController@signup');
    });
    Route::group(['middleware' => 'auth:api'], function () {
        Route::get('logout', 'Api\AuthController@logout');
        Route::get('getuser', 'Api\AuthController@getUser');
    });
});

//La Chopi Routes
Route::group(['prefix' => 'chopi'], function () {
    //Get Categories
    Route::get('generate', 'Api\LachopigenerationController@generate')->name('api_generate_lachopi');
});

//Save Image from AJAX Calls and API implementation
Route::get('show-image', 'Api\ImageController@index')->name('show-image-ajax');
Route::post('save-image', 'Api\ImageController@save')->name('save-image-ajax');
Route::post('delete-image', 'Api\ImageController@destroy')->name('delete-image-ajax');
Route::post('save-profile-image', 'Api\ImageController@save_profile_image')->name('save-profile-image-ajax');
