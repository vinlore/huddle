<?php

Route::get('syslogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {

    // -------------------------------------------------------------------------
    // AUTHORIZATION
    // -------------------------------------------------------------------------

    Route::post('auth/register', 'AuthController@signup');
    Route::post('auth/login', 'AuthController@signin');
    Route::post('auth/logout', 'AuthController@signout');
    Route::post('auth/confirm', 'AuthController@confirm');

    // -------------------------------------------------------------------------
    // ACTIVITIES
    // -------------------------------------------------------------------------

    Route::get('activities', 'ActivityController@index');
    Route::get('users/{uid}/activities', 'ActivityController@indexWithUser');

    // -------------------------------------------------------------------------
    // ROLES
    // -------------------------------------------------------------------------

    Route::resource('roles', 'RoleController', ['only' =>[
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // USERS
    // -------------------------------------------------------------------------

    Route::resource('users', 'UserController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // PROFILES
    // -------------------------------------------------------------------------

    Route::get('profile/{pid}/conferences', 'ProfileController@conferences');
    Route::get('profile/{pid}/events', 'ProfileController@events');
    Route::get('profile/{pid}/rooms', 'ProfileController@rooms');
    Route::get('profile/{pid}/conferences/vehicles', 'ProfileController@conferenceVehicles');
    Route::get('profile/{pid}/events/vehicles', 'ProfileController@eventVehicles');
    Route::resource('users.profiles', 'ProfileController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // CONFERENCES
    // -------------------------------------------------------------------------

    Route::get('conferences/status/{status}', 'ConferenceController@indexWithStatus');
    Route::get('conferences/{cid}/events/status/{status}', 'ConferenceController@eventsWithStatus');
    Route::resource('conferences', 'ConferenceController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // EVENTS
    // -------------------------------------------------------------------------

    Route::get('events/{status}', 'EventController@indexWithStatus');
    Route::resource('conferences.events', 'EventController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // ACCOMMODATIONS
    // -------------------------------------------------------------------------

    Route::resource('conferences.accommodations', 'AccommodationController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // ROOMS
    // -------------------------------------------------------------------------

    Route::resource('accommodations.rooms', 'RoomController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('rooms.guests', 'RoomGuestController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // ITEMS
    // -------------------------------------------------------------------------

    Route::resource('conferences.inventory', 'ItemController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // VEHICLES
    // -------------------------------------------------------------------------

    Route::resource('conferences.vehicles', 'ConferenceVehicleController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.vehicles', 'EventVehicleController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('vehicles.passengers', 'VehiclePassengerController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // MANAGERS
    // -------------------------------------------------------------------------

    Route::resource('conferences.managers', 'ConferenceManagerController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.managers', 'EventManagerController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // ATTENDEES
    // -------------------------------------------------------------------------

    Route::resource('conferences.attendees', 'ConferenceAttendeeController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events.attendees', 'EventAttendeeController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);
});
