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
    return view('auth.login');
});

//PARTIE UTILISATEUR
Route::get('/home', 'MatchsController@index')->name('home');
Route::get('/', 'MatchsController@index')->name('root');

Route::get('profil', 'UsersController@edit')->name('profil');
Route::put('profil/{user}', 'UsersController@update')->name('profil.update');
Route::get('teams', 'TeamsController@index')->name('teams');
Route::get('teams/{id}', 'TeamsController@show')->name('teams.stats');
Route::get('players', 'PlayersController@index')->name('players');
Route::get('matches/stats/{match_id?}', 'MatchsController@show')->name('show.stats');
Route::get('matches/{status?}/{team_id?}', 'MatchsController@index')->name('matches');
Route::get('bets', 'BetsController@index')->name('my-bets');
Route::get('bets/create/{match_id}', 'BetsController@create')->name('new-bet');
Route::post('bets', 'BetsController@store')->name('bets.store');

Auth::routes();

//PARTIE ADMIN
Route::group(['namespace' => 'Admin', 'prefix' => 'admin'], function() {
    Route::resource('users','UsersController');
    Route::resource('teams','TeamsController');
    Route::resource('players', 'PlayersController');
    Route::resource('matches', 'MatchsController');
    Route::get('matches/stats/{match_id}/edit', 'MatchsController@stats')->name('admin.matches.stats');
    Route::put('matches/stats/{match_id}', 'MatchsController@update_stats')->name('admin.matches.update_stats');
    Route::get('bets', 'BetsController@index')->name('bets.index');
});
