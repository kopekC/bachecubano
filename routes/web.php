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

//Welcome Route
Route::get('/', 'WelcomeController@index')->name('welcome')->middleware('cacheResponse:300');         //Cache 5min

Route::middleware('cacheResponse')->group(function () {                             //Cache response
    Route::get('/contact', 'WelcomeController@contact')->name('contact');
});

//Contact    
Route::post('/contact', 'WelcomeController@contact_submit')->name('contact_submit');

//User Login/Register/Change Password routes
Auth::routes();

// Posts resourcfull controllers routes
Route::get('/blog/{entry_slug}', 'PostController@show')->name('blog_post');
Route::resource('/blog', 'PostController');

//User Routes for Configuration 
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/ads', 'HomeController@ads')->name('my_ads');
Route::get('/home/favourite', 'HomeController@favourite')->name('my_favourite');
Route::get('/home/settings', 'HomeController@settings')->name('my_settings');
Route::get('/home/payments', 'HomeController@payments')->name('my_payments');

//Cart Routes
Route::resource('cart', 'CartController');

//Sharing Routes
Route::get('/share/{network}/{url}/{text}', 'ShareController@index')->name('share');

//Ads Routes & Resource Route
Route::get('/add', 'AdController@create')->name('add')->middleware('cacheResponse:86400');;          //Cache daily ->middleware('cacheResponse:86400');
Route::get('/{category}/', 'AdController@index')->name('super_category_index');
Route::get('/{category}/{subcategory}/', 'AdController@index')->name('category_index');
Route::get('/{category}/{subcategory}/{ad_title}/{ad_id}', 'AdController@show')->name('show_ad');
Route::resource('ad', 'AdController');

//Search route
Route::get('/search', 'SearchController@search')->name('search');

//SubDomain Stores
Route::domain('{store_name}.bachecubano.com')->group(function () {
    Route::get('store/{store_name}', 'StoreController@show')->name('store_index');
});
