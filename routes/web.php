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

// Route::get('/', function () {
//     return view('backup-database');
// });

Route::get('/',"DownloadController@databaseListing");
Route::get('/index',"DownloadController@databaseListing")->name("index");
Route::get('/save_all',"DownloadController@saveAll")->name("save_all");
Route::get('/save'  , 'DownloadController@getDataBase')->name('save');
