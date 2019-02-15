<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::get('/', function () {
     return redirect('league-table');   
});

Auth::routes();

Route::resource('/league-table', 'LeagueTableController');
Route::resource('/players', 'PlayersController');

