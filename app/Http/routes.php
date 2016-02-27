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
Route::post ('auth', 'authenticate_user_controller@authenticate_user');
Route::get ('login', function(){
	return View::make('login');
});
	//Registration page
Route::post ('create', 'create_user_controller@create_user');
Route::get ('register', function() {
	return View::make('register');
});

	//Sucess or Fail Page
Route::get('success', function(){
		return "Success";
});
Route::get('fail', function(){
	return "Fail";
});

	//Checking the output
Route::get('checkUser', function(){
	if ($user = Sentinel::check())
{
    // User is logged in and assigned to the `$user` variable.
	var_dump($user);
}
else
{
    // User is not logged in
	var_dump($user);
}

});

	//Activate the Account
Route::get('verif', 'verification_controller@verification_code_check');

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
