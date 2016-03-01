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
	$reminder_code = $_GET['reminder_code'];
	$new_password = $_GET['new_pass'];
	$user = Sentinel::findById(5);
	//return Reminder::create($user);

	if ($reminder = Reminder::complete($user, $reminder_code, $new_password)){
		return "{'sucess' : true}";
	}else{
	    return "{'success' : true, 'error' : { 'code' : 'Apollo', 'message' : 'Problem occured trying to reset password'}}";
	}
	
});

/*
 * DEV - TESTING PAGES
 */
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
		Route::get('tok' , function() {
		  return "Protected resource";
		});

		/*
		* 	Conference API
		*/

		//Return list of conferences
		Route::get('conferences' , 'Conference_Controller@get_conferences');

		//Returns a conference
		Route::get('conferences' , 'Conference_Controller@get_conference');

		//Delete a conference
		Route::delete('conferences' , 'Conference_Controller@delete_conference');

		//Creates a conference
		Route::post('conferences' ,  'Conference_Controller@create_conference');

		//Updates a conference
		Route::put('conferences' , 'Conference_Controller@update_conference');

		//Return list of attendees
		Route::get('conferences/attendees' , 'Conference_Controller@get_attendees');

		//Add an attendee
		Route::post('conferences/attendees' , 'Conference_Controller@add_attendee');

		//Delete an attendee
		Route::delete('conferences/attendees' , 'Conference_Controller@delete_attendee');

		//Update attendee
		Route::put('conferences/attendees' , 'Conference_Controller@update_attendee');

		//Returns list of accommodations
		Route::get('conferences/accommodations' , 'Conference_Controller@get_accommodations');

		//Adds accommodations
		Route::post('conferences/accommodations' , 'Conference_Controller@add_accommodation');

		//Delete accommodation
		Route::delete('conferences/accommodations' , 'Conference_Controller@delete_accommodation');

		//Update accommodation
		Route::put('conferences/accommodations' , 'Conference_Controller@update_accommodation');

		//Returns list of inventory items
		Route::get('conferences/inventory' , 'Conference_Controller@get_inventory');

		//Add item to inventory
		Route::post('conferences/inventory' , 'Conference_Controller@add_item');

		//Delete item from inventory
		Route::delete('conferences/inventory' , 'Conference_Controller@delete_item');

		//Update item from inventory
		Route::put('conferences/inventory' , 'Conference_Controller@update_item');

		/*
		*	Event API
		*/

		//Returns a list of events
		Route::get('conferences/events' , 'Event_Controller@get_events');

		//Returns an events
		Route::get('conferences/event' , 'Event_Controller@get_event');

		//Deletes an event
		Route::delete('conferences/events' , 'Event_Controller@delete_event');

		//Create an events
		Route::post('conferences/events' , 'Event_Controller@create_event');

		//Update an event
		Route::put('conferences/events' , 'Event_Controller@update_event');

		//Return List of attendees
		Route::get('conferences/events/attendees' , 'Event_Controller@get_attendees');

		//Add attendee to event
		Route::post('conferences/events/attendee' , 'Event_Controller@add_attendee');

		//delete attendee from event
		Route::delete('conferences/events/attendees' , 'Event_Controller@delete_attendee');

		/*
		*	Profile API
		*/

		//Returns a user Profile
		Route::get('users/profile' , 'Profile_Controller@get_profile');

		//Update profile
		Route::put('users/profile' , 'Profile_Controller@update_profile');

		//Update permissions
		Route::post('permissions' , 'Profile_Controller@update_permissions');

		//Delete users
		Route::delete('users' , 'Profile_Controller@delete_user');

		//Deactivate users
		Route::put('users' , 'Profile_Controller@deactivate_user');


	});
