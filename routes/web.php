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

Route::get('/client/hall/{reservation}', 'HallController@hall')->middleware('auth');
Route::get('/start/get-json/{id}', 'HallController@getJson');
Route::get('/start/update-ajax/{id}', 'HallController@updateStatus');

Route::get('/client/payment/{id}', 'PagesController@payment')->middleware('auth');
Route::get('/client/ticket/{id}', 'PagesController@ticket')->middleware('auth');

Route::get('/admin', 'AdminsController@index')->middleware('auth');
Route::get('/admin/create', 'AdminsController@create')->middleware('auth');
Route::post('/admin/hall', 'AdminsController@save')->middleware('auth');
Route::delete('/admin/hall/{id}', 'AdminsController@delete')->middleware('auth');
Route::get('/admin/get-api-places/{id_hall}', 'AdminsController@getApi')->middleware('auth');
Route::get('/admin/post-api-row/{id_hall}/{num}', 'AdminsController@postApiRow')->middleware('auth');
Route::get('/admin/get-update-place-in-row/{id_hall}/{num}', 'AdminsController@updatePlaceInRow')->middleware('auth');


// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/about', function () {
//     return view('about');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('/client/hall', 'HallController');
