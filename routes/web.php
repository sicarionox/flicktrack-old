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

Route::get('/', 'PagesController@index');
Route::get('/movies', 'PagesController@movies');

Route::get('/tvshows', 'TVShowsController@index');
Route::get('/tvshows/{tvshow}', 'TVShowsController@show')->name('tvshow');
Route::get('/episodes/{episodeid}', 'TVShowsController@showEpisode');
Route::get('tvshows/{tvshow}/mark', 'TVShowsController@markFavourite');
Route::get('/episodes/{episode}/markwatched', 'TVShowsController@markWatched');
Route::get('/tvshows/{tvshow}/addcomment', 'TVShowsController@addComment');
Route::delete('/tvshows/{tvshow}/deletecomment', 'TVShowsController@deleteComment');
Route::get('/tvshows/{tvshow}/rate/{rating}', 'TVShowsController@rate')->name('rateEpisode');
Route::get('/tvshows/search', 'TVShowsController@searchShow')->name('searchShow');
//Route::get('/tvshows?showname={showName}', 'TVShowsController@searchShow')->name('searchShow');
    
    
Route::get('/movies', 'MoviesController@index');
Route::get('/movies/{movie}', 'MoviesController@show')->name('movie');
Route::get('/movies/{movie}/markfav', 'MoviesController@markFavourite');
Route::get('/movies/{movie}/markwatched', 'MoviesController@markWatched');
Route::get('/movies/{movie}/delete', 'MoviesController@deleteComment');
Route::get('/movies/{movie}/postComment', 'MoviesController@addComment');
Route::get('/movies/{movie}/rate/{rating}', 'MoviesController@rate')->name('rateMovie');

Route::get('/profile/{id}', 'AccController@profile');
Route::get('/settings', 'AccController@showsettings');
Route::post('/settings','AccController@changePassword')->name('changePassword');




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
