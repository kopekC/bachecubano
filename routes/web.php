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
Route::get('/', 'WelcomeController@index')->name('welcome');

//Ads Routes & Resource Route
Route::get('/add', 'AdController@create')->name('add');
Route::get('/{category}/', 'AdController@index')->name('super_category_index');
Route::get('/{category}/{subcategory}/', 'AdController@index')->name('category_index');
Route::get('/{category}/{subcategory}/{ad_title}/{id}', 'AdController@show')->name('show_ad');
Route::resource('ad', 'AdController');

//Search route
Route::get('/search', 'SearchController@search')->name('search');

//User Login/Register/Change Password routes
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');

//SubDomain Stores
Route::domain('{store_name}.bachecubano.com')->group(function () {
    Route::get('store/{store_name}', 'StoreController@index')->name('store_index');
});
