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

//SubDomain Mapping
use Illuminate\Support\Facades\Route;

Route::group(['domain' => 'api.bachecubano.com'], function () {

    Route::get('/', 'Api\HomeController@index')->name('welcome_api')->middleware('cacheResponse:300');         //Cache 5min

    Route::group(['prefix' => 'v1'], function () {

        Route::get('/', 'Api\HomeController@index')->name('welcome_api')->middleware('cacheResponse:300');         //Cache 5min

        //Get Categories
        Route::get('categories', 'Api\AdsController@get_categories')->name('api_get_categories');
        //Get Ads From certain Category
        Route::get('ads/{category_id}', 'Api\AdsController@get_ads')->name('api_get_ads');
        //Get Specific Ad
        Route::get('ad/{ad_id}', 'Api\AdsController@get_ad')->name('api_get_ad');

        //Search model
        Route::get('search', 'Api\AdsController@search')->name('api_search');
        //Like/Dislike behavior
        Route::get('ad_like/{ad}', 'Api\LikeController@ad_like')->name('ad_like');
        //Like/Dislike behavior
        Route::get('ad_dislike/{ad}', 'Api\LikeController@ad_dislike')->name('ad_dislike');
        //Like/Dislike behavior
        Route::get('ad_hit_like/{ad}', 'Api\LikeController@ad_hit_like')->name('ad_hit_like');

        //SMS Post
        Route::post('send_sms', 'Api\SmsController@send_sms')->name('api_send_sms');

        //La Chopi Routes
        Route::group(['prefix' => 'lachopi'], function () {
            //Generate LaChopi after update_promoted_ads
            Route::get('status', 'Api\LachopigenerationController@status')->name('api_status_lachopi');
            Route::get('generate', 'Api\LachopigenerationController@generate')->name('api_generate_lachopi');
        });

        //Cron Routes
        Route::group(['prefix' => 'cron'], function () {
            //Clean older promotions
            Route::get('promoclean', 'Api\CronController@delete_old_promotions')->name('promoclean');
            //Advise for next ending promos
            Route::get('promoadvise', 'Api\CronController@notify_ending_promos')->name('promoadvise');
            //Update Ads which has some promotion applied
            Route::get('update_promoted_ads', 'Api\CronController@update_promoted_ads')->name('update_promoted_ads');
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
    });

    //Telegram Routes with token parameter
    Route::group(['prefix' => 'telegram'], function () {
        Route::get('getme/' . config('telegram.webhook_token'), 'Api\TelegramController@getme')->name('getme');                         //Bot Basic Info
        Route::get('getupdates/' . config('telegram.webhook_token'), 'Api\TelegramController@getupdates');                              //Bot Get Messages info
        Route::post('webhook/' . config('telegram.webhook_token'), 'Api\TelegramController@webhook')->name('webhook');                  //Bot WebHook test
        Route::get('sendmessage/' . config('telegram.webhook_token'), 'Api\TelegramController@sendmessage')->name('sendmessage');      //Send Specific message 😉
    });

    // The catch-all will match anything except the previous defined routes.
    Route::any('{catchall}', 'Api\HomeController@index')->where('catchall', '.*');
});
