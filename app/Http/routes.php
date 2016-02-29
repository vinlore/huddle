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
 * Account - Login System
 */
 	//Authenticaiton and Login
Route::post ('auth', 'Authenticate_Controller@user_authentication');
Route::get ('login', function(){
	return View::make('login');
});
	//Registration page
Route::post ('create', 'Authenticate_Controller@user_registration');
Route::get ('register', function() {
	return View::make('register');
});

	//Activate the Account
Route::get('activation', 'Authenticate_Controller@user_activation');

	//Log Out
Route::post('logout', function(){
	$api_token = $_POST['api_token'];
	DB::table('users')->where('api_token', $api_token)->update('api_token','');
	return "{'success' : true}";
});
	//Password reset
Route::get('passwordreset',function(){
	$reminder_code = $_POST['reminder_code'];
	$new_password = $_POST['new_pass'];
	$user = Sentinel::findById(1);
	if ($reminder = Reminder::complete($user, $reminder_code, $new_password)){
		return "{'sucess' : true}";
	}else{
	    return "{'success' : true, 'error' : { 'code' : 'Apollo', 'message' : 'Problem occured trying to reset password'}}";
	}
});

/*
 * DEV - TESTING PAGES
 */

	//Sucess or Fail Page
Route::get('success', function(){
		return "Success";
});
Route::get('fail', function(){
	return "Fail";
});


	//Creating roles - Called Admin
Route::get('createRole', function(){
	$role = Sentinel::getRoleRepository()->createModel()->create([
    'name' => 'Admin',
    'slug' => 'Admin',]);
	var_dump($role);
});

Route::get('assignRole', function(){

	$user = Sentinel::findById(50);
	$role = Sentinel::findRoleByName('Admin');
	$role->users()->attach($user);
	var_dump($role);
});

Route::get('removeRole', function(){

	$user = Sentinel::findById(50);
	$role = Sentinel::findRoleByName('Admin');
	$role->users()->detach($user);
	var_dump($role);
});

Route::get('addRolePermission', function(){
	$role = Sentinel::findRoleById(1);

	$role->permissions = [
    	'event.update' => true,
    	'event.view' => false,
	];

	$role->save();
	var_dump($role);
});

/**
 * API ROUTES
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
	//Security for all url with /api
	Route::group(['middleware' => ['authToken'],'prefix' => 'api'], function () {
		//Development Purposes
		Route::get('tok', function() {
		  return "Protected resource";
		});


	});
