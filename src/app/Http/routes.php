<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

Route::group(['middleware' => ['web']], function () {
  Route::get('/', function () {return view('welcome'); });
  Route::get('/authorize', 'Auth\AuthController@handleProviderCallback');
  Route::get('/auth', 'Auth\AuthController@redirectToProvider');
  Route::get('/login', 'Auth\AuthController@redirectToProvider');
});

Route::group(['middleware' => ['web', 'auth', 'google']], function () {

    Route::get('/home', 'HomeController@index');
    Route::get('/home/{display}', 'HomeController@index');
    Route::resource('/calendar', 'CalendarController');
    Route::resource('/event', 'EventController');
    Route::get('/event/delete/{event}', 'EventController@delete');
    Route::get('/event/paid/{event}', 'EventController@paid');
    Route::get('/event/unpaid/{event}', 'EventController@unpaid');
});
