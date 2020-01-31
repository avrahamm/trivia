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

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');


Route::get('/trivia/login', 'PlayerController@login')->name('player.login');
//    ->middleware('guest');
Route::get('/', function(){
    return redirect()->route('player.login');
})->middleware('guest');
Route::post('/trivia/login', 'PlayerController@saveUser')->name('player.saveUser');
//    ->middleware('guest');

Route::get('/trivia/start', 'QuestionController@create')->name('question.create')->middleware('auth');

Route::get('/trivia/play', 'GameController@displayForm')->name('game.form')->middleware('auth');
Route::post('/trivia/play', 'GameController@checkAnswer')->name('game.checkAnswer')->middleware('auth');
