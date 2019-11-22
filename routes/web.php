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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/admin', 'AdminController@index')->middleware('auth');

Route::group(['prefix' => 'admin'], function () {
    Route::get('/images', 'DataImageController@index')->middleware('auth');
    Route::get('/images/{id}/edit', 'DataImageController@edit')->middleware('auth');
    Route::post('/images/store', 'DataImageController@store')->middleware('auth');
    Route::get('/images/delete/{id}', 'DataImageController@destroy')->middleware('auth');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('auth/{provider}', 'Auth\SocialiteController@redirectToProvider');
Route::get('auth/{provider}/callback', 'Auth\SocialiteController@handleProviderCallback');
