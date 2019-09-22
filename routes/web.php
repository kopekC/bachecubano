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

//Contact
Route::get('/contact', 'WelcomeController@contact')->name('contact')->middleware('cacheResponse:86400', 'cache.headers:public,max-age=86400;etag');
Route::post('/contact', 'WelcomeController@contact_submit')->name('contact_submit');

//User Login/Register/Change Password routes
Auth::routes();


//Feeds
Route::feeds();

// Posts resourcfull controllers routes
Route::get('/blog/{entry_slug}', 'PostController@show')->name('blog_post')->middleware('cacheResponse:86400', 'cache.headers:private,max-age=300;etag');      //Cached for 5 minutes
Route::resource('/blog', 'PostController');

//User Routes for Configuration (Mainly registered area)
Route::get('/home', 'HomeController@index')->name('home');
Route::get('/home/ads', 'HomeController@ads')->name('my_ads');
Route::get('/home/favourite', 'HomeController@favourite')->name('my_favourite');
Route::get('/home/settings', 'HomeController@settings')->name('my_settings');
Route::get('/home/payments', 'HomeController@payments')->name('my_payments');
Route::post('/home/delete', 'HomeController@delete_account')->name('delete_account');
Route::post('/home/update', 'HomeController@update_user')->name('update_user');

//Cart Routes
Route::resource('cart', 'CartController');

//Sharing Routes
Route::get('/share/{network}/{url}/{text}', 'ShareController@index')->name('share');
Route::get('/invite/{item}/{misc}', 'ShareController@invite')->name('invite');

//Search route
Route::get('/search', 'SearchController@search')->name('search');

//Ads Routes & Resource Route
Route::get('/add', 'AdController@create')->name('add')->middleware('cacheResponse:86400');          //Cache daily ->middleware('cacheResponse:86400');
//Promote Ad
Route::get('/promote/{ad}', 'AdController@promote')->name('ad.promote');
//Category Listing
Route::get('/{category}/', 'AdController@index')->name('super_category_index');
//SubCategory Listing
Route::get('/{category}/{subcategory}/', 'AdController@index')->name('category_index')->middleware('cacheResponse:30', 'cache.headers:private,max-age=30;etag');
//Ad specific Show
Route::get('/{category}/{subcategory}/{ad_title}/{ad_id}', 'AdController@show')->name('show_ad')->middleware('cacheResponse:120', 'cache.headers:private,max-age=120;etag');
//Ad promotion Page
Route::get('/promote/{ad}', 'AdController@promote_ad')->name('promote_ad');
Route::post('/promote/{ad}', 'AdController@post_promote_ad')->name('post_promote_ad')->middleware('auth');      //Access only if its registere4d user
//Ad resources route
Route::resource('ad', 'AdController');

//SubDomain Stores
Route::domain('{store_name}.bachecubano.com')->group(function () {
    Route::get('store/{store_name}', 'StoreController@show')->name('store_index');
});
