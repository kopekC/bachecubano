<?php

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

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('generate', 'Api\LachopigenerationController@generate')->name('api_generate_lachopi');

//Welcome Route
Route::get('/', 'WelcomeController@index')->name('welcome')->middleware('cacheResponse:300');         //Cache 5min

//Contact
Route::get('/contact', 'WelcomeController@contact')->name('contact');
Route::post('/contact', 'WelcomeController@contact_submit')->name('contact_submit');

//Imap Controller every 1 min
Route::get('/imap_check', 'ImapController@imap_check')->name('imap_check');

//Image Manipulation
Route::post('save-image', 'Api\ImageController@save')->name('save-image-ajax');
Route::post('delete-image', 'Api\ImageController@destroy')->name('delete-image-ajax');
Route::post('save-profile-image', 'Api\ImageController@save_profile_image')->name('save-profile-image-ajax');

//User Login/Register/Change Password routes
Auth::routes();

// Posts resourcfull controllers routes
Route::get('/blog/create', 'PostController@create')->name('blog_post_create');
Route::resource('/blog', 'PostController');
Route::get('/blog/{entry_slug}', 'PostController@show')->name('blog_post');

//User Routes for Configuration (Mainly registered area)
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/ads', 'HomeController@ads')->name('my_ads');
Route::get('/home/favourite', 'HomeController@favourite')->name('my_favourite');
Route::get('/home/settings', 'HomeController@settings')->name('my_settings');
Route::get('/home/payments', 'HomeController@payments')->name('my_payments');
Route::post('/home/delete', 'HomeController@delete_account')->name('delete_account');
Route::post('/home/update', 'HomeController@update_user')->name('update_user');
Route::post('/home/update_password', 'HomeController@update_user_password')->name('update_user_password');

//SMS Routes
Route::get('/home/send_sms', 'HomeController@send_sms')->name('send_sms');

//Trasnfer Money Routes
Route::get('/home/transfer_money', 'HomeController@transfer_money')->name('transfer_money');
Route::post('/home/transfer_money', 'HomeController@transfer_money_post')->name('transfer_money_post');

//Sitemap Creator Has to be here, On Api breaks Urls from generated indexes
Route::get('sitemap', 'Api\SitemapController@sitemap_index')->name('sitemap_index');

//Cart Routes
Route::resource('cart', 'CartController');

//Sharing Routes
Route::get('/share/{network}/{url}/{text}', 'ShareController@index')->name('share');
Route::get('/invite/{item}/{misc}', 'ShareController@invite')->name('invite');

//Ad promotion Page
Route::get('/promote/{ad}', 'AdController@promote_ad')->name('promote_ad')->middleware('auth');
Route::post('/promote/{ad}', 'AdController@post_promote_ad')->name('post_promote_ad')->middleware('auth');      //Access only if its registere4d user
//Ads Routes & Resource Route
Route::get('/add', 'AdController@create')->name('add');
//update_all
Route::get('/update_all', 'AdController@update_all')->middleware('throttle:1,30')->name('update_all');      //Update All ads every 30 minutes only
//Delete Ad direct link
Route::get('/delete/{ad}', 'AdController@destroy')->name('delete_ad')->middleware('auth');
//Category Listing
Route::get('/{category}/', 'AdController@index')->name('super_category_index');
//SubCategory Listing
Route::get('/{category}/{subcategory}/', 'AdController@index')->name('category_index')->middleware('cacheResponse:30', 'cache.headers:private,max-age=30;etag');
//Ad specific Show
//Route::get('/{category}/{subcategory}/{ad_title}/{ad_id}', 'AdController@show')->name('show_ad')->middleware('cacheResponse:120', 'cache.headers:private,max-age=120;etag')->where('ad_id', '[0-9]+'); //only allow numeric ID
Route::get('/{category}/{subcategory}/{ad_title}/{ad_id}', 'AdController@show')->name('show_ad')->middleware('cacheResponse:120', 'cache.headers:private,max-age=120;etag')->where('ad_id', '[0-9]+'); //only allow numeric ID
//Laravel Images redirection to subdomain
Route::get('/oc-content/uploads/{folder_id}/{resource_name}', 'AdController@redirectto_image');
//Ad resources route
Route::resource('ad', 'AdController');

//SubDomain Stores
Route::domain('{store_name}.bachecubano.com')->group(function () {
    Route::get('store/{store_name}', 'StoreController@show')->name('store_index');
});
