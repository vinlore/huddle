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

/**
 * HOME PAGE
 */
Route::get('/', function () {
	return View::make('index');
});

/**
 * API ROUTES
 */

/**
 * CATCH ALL
 */
App::missing(function ($exception) {
	return View::make('index');
});