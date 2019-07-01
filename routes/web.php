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

//Ads Routes

//Search route
Route::get('/search', 'SearchController@search')->name('search');

//User Login/Register/Change Password routes
Auth::routes();
Route::get('/home', 'HomeController@index')->name('home');
