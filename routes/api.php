<?php

use Illuminate\Http\Request;

Route::get('users', 'UserController@index');
Route::get('users/{id}', 'UserController@show');
Route::post('users', 'UserController@store');
Route::put('users/{id}', 'UserController@update');
Route::delete('users/delete/{id}', 'UserController@destroy');
Route::delete('users/remove_from_team', 'UserController@remove_from_team');
Route::post('users/add_to_team', 'UserController@add_to_team');

Route::get('teams', 'TeamController@index');
Route::get('teams/{id}', 'TeamController@show');
Route::post('teams', 'TeamController@store');
Route::put('teams/{id}', 'TeamController@update');
Route::delete('teams/{id}', 'TeamController@destroy');
