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


Auth::routes();

Route::get('/', 'HomeController@index')->name('home');

Route::group(['middleware'=>'auth'],function (){
    Route::get('/user-area','UserController@index');
    Route::group(['prefix'=>'user'],function (){
       Route::post('request','UserController@request');
       Route::post('cancel-request','UserController@cancelRequest');
       Route::get('getAssets','UserController@getAssets');
    });
});

Route::group(['prefix'=>'manage','middleware'=>'admin'],function (){
    Route::resource('assets','AssetController');
    Route::resource('categories','CategoryController');
    Route::get('view-report','ManageController@viewReport');
    Route::get('borrow-list','ManageController@index');
    Route::get('list','ManageController@getList');
    Route::post('allow-asset','ManageController@allowAsset');
    Route::post('deny-asset','ManageController@denyAsset');
});

