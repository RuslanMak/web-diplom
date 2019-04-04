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

Route::get('/', 'PagesController@home');
Route::get('/about', 'PagesController@about');
Route::get('/client', 'PagesController@client');
Route::get('/client/hall/{reservation}', 'PagesController@hall');
Route::get('/client/payment', 'PagesController@payment');
Route::get('/client/ticket', 'PagesController@ticket');

Route::get('/admin', 'AdminsController@index');


// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/about', function () {
//     return view('about');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/start/get-json/{id}', 'HallController@getJson');
Route::get('/start/update-ajax/{id}', 'HallController@updateStatus');

//Route::resource('/client/hall', 'HallController');
