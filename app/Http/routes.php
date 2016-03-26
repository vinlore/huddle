<?php

// -----------------------------------------------------------------------------
// API
// -----------------------------------------------------------------------------


// Routes that don't require the user to be logged in.
Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {
    Route::post('auth/register', 'AuthController@register');
    Route::post('auth/login', 'AuthController@login');
    Route::post('auth/logout', 'AuthController@logout');
});

// Prefix all API routes with 'api'. - TODO - Make sure to add, AuthToken
Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {

    Route::post('auth/confirm', 'AuthController@confirm');

    Route::get('auth/activity', 'ActivityController@get');

    Route::resource('roles' , 'RoleController', ['only' =>[
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // Profile Attend Conference
    Route::resource('profile.conference' , 'ProfileAttendsConferenceController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    Route::post('profile.conference.status', 'ProfileAttendsConferenceController@profileConferenceStatusUpdate');

    //Profile Attend Event
    Route::resource('profile.event' , 'ProfileAttendsEventController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    Route::post('profile.event.status', 'ProfileAttendsEventController@profileEventStatusUpdate');

    //User Manages Conference
    Route::resource('user.conference' , 'UserManagesConferenceController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    //User Manages Events
    Route::resource('user.event' , 'UserManagesEventsController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    Route::resource('users', 'UserController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('users.profiles', 'ProfileController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    Route::post('conference.status', 'ConferenceController@conferenceStatusUpdate');

    Route::resource('conferences', 'ConferenceController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::post('event.status', 'EventController@eventStatusUpdate');

    Route::resource('conferences.accommodations', 'AccommodationController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('conferences.accommodations.rooms', 'RoomController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('conferences.inventory', 'ItemController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('conferences.vehicles', 'ConferenceVehicleController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('conferences.attendees', 'ConferenceAttendeeController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('conferences.managers', 'ConferenceManagerController', ['only' => [
        'index', 'store', 'show', 'destroy',
    ]]);

    Route::resource('conferences.events', 'EventController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.attendees', 'EventAttendeeController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.vehicles', 'EventVehicleController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.managers', 'EventManagerController', ['only' => [
        'index', 'store', 'show', 'destroy',
    ]]);
});

// -----------------------------------------------------------------------------
// TESTING
// -----------------------------------------------------------------------------


// Reset the first user's password.
Route::get('api/passwordreset',function () {
    $reminderCode = $_GET['reminder_code'];
    $newPassword = $_GET['new_pass'];
    $user = Sentinel::first();
    if ($reminder = Reminder::complete($user, $reminderCode, $newPassword)) {
        return Response::json(array('success' => true,));
    } else {
        return Response::json(array('success' => false,));
    }
});
