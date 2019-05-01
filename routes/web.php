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
Route::get('/client', 'PagesController@client');

Route::get('/client/hall/{reservation}', 'HallController@hall')->middleware('auth');
Route::get('/start/get-json/{id}', 'HallController@getJson');
Route::get('/start/update-ajax/{id}', 'HallController@updateStatus')->middleware('auth');

Route::get('/client/payment/{id}', 'PagesController@payment')->middleware('auth');
Route::get('/client/ticket/{id}', 'PagesController@ticket')->middleware('auth');

Route::get('/admin', 'AdminsController@index')->middleware('auth', 'role:admin');
Route::get('/admin/create', 'AdminsController@create')->middleware('auth', 'role:admin');
Route::post('/admin/hall', 'AdminsController@save')->middleware('auth', 'role:admin');
Route::delete('/admin/hall/{id}', 'AdminsController@deleteHall')->middleware('auth', 'role:admin');
Route::get('/admin/get-api-places/{id_hall}', 'AdminsController@getApi')->middleware('auth', 'role:admin');
//Route::get('/admin/post-api-row/{id_hall}/{num}', 'AdminsController@updateNumRow')->middleware('auth', 'role:admin');
//Route::get('/admin/get-update-place-in-row/{id_hall}/{num}', 'AdminsController@updateNumPlaceInRow')->middleware('auth', 'role:admin');
//Route::get('/admin/get-update-type-place-doing/{row}/{num}/{type}/{id_hall}', 'AdminsController@updateTypePlace')->middleware('auth', 'role:admin');
Route::post('/admin/get-update-type-place-doing/{rows}/{nums}/{id_hall}', 'AdminsController@saveTypePlace')->middleware('auth', 'role:admin');


//Route::get('/admin/get-cancel-change/{pass}/{id_hall}', 'AdminsController@cancelChange')->middleware('auth', 'role:admin');
//Route::get('/admin/get-save-change/{id_hall}', 'AdminsController@saveChange')->middleware('auth', 'role:admin');
Route::post('/admin/post-save-prices', 'AdminsController@savePrices')->middleware('auth', 'role:admin');

Route::get('/admin/get-all-movie', 'AdminsController@allMoviesApi')->middleware('auth', 'role:admin');
Route::post('/admin/save-new-movie', 'AdminsController@saveNewMovie')->name('image.upload')->middleware('auth', 'role:admin');
Route::post('/admin/save-new-time-for-movie', 'AdminsController@saveMovieTime')->middleware('auth', 'role:admin');
Route::delete('/admin/delete-movie-for-hall/{id_connection}', 'AdminsController@deleteMovieFromHall')->middleware('auth', 'role:admin');

Route::get('/admin/open-sale', 'AdminsController@openSale')->middleware('auth', 'role:admin');
Route::get('/admin/get-all-halls', 'AdminsController@allHallsApi')->middleware('auth', 'role:admin');

Route::get('/controller', 'PagesController@controller')->middleware('auth', 'role:controller');

Route::get('/times-of-movies-and-more', 'PagesController@getTimesAndMore');
Route::get('/client-data-of-selected-date/{date}', 'PagesController@getDataOfDate');
Route::get('/client-data-of-movie/{id_movie}', 'PagesController@getDataOfMovie');
Route::get('/client-get-hall-name/{id_hall}', 'PagesController@getHallName');


// Route::get('/', function () {
//     return view('welcome');
// });


// Route::get('/about', function () {
//     return view('about');
// });

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route::resource('/client/hall', 'HallController');
