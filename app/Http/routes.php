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

// Laravel welcome page for demonstration
Route::get('welcome', function () {
	return View::make('welcome');
});

/**
 * DEV - TESTING PAGES
 */
 	//Authenticaiton and Login
Route::post('auth', 'authenticate_user_controller@authenticate_user');
Route::get('login', function(){
	return View::make('login');
});
	//Registration page
Route::post('create', 'create_user_controller@create_user');
Route::get('register', function() {
	return View::make('register');
});

/**
 * API ROUTES
 */
	//Security for all url with /api
	Route::group(['middleware' => ['authToken'],'prefix' => 'api'], function () {
		Route::get('tok', function() {
		  return "Protected resource";
		});
	});



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
