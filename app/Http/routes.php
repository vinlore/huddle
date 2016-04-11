<?php

Route::get('syslogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {

    // -------------------------------------------------------------------------
    // AUTHENTICATION
    // -------------------------------------------------------------------------

    Route::post('auth/register', 'AuthController@signup');
    Route::post('auth/login', 'AuthController@signin');
    Route::post('auth/logout', 'AuthController@signout');
    Route::post('auth/confirm', 'AuthController@confirm');

    // -------------------------------------------------------------------------
    // ACTIVITY LOG
    // -------------------------------------------------------------------------

    Route::get('activities', 'ActivityController@index');
    Route::get('users/{uid}/activities', 'ActivityController@indexWithUser');

    // -------------------------------------------------------------------------
    // ROLES
    // -------------------------------------------------------------------------

    Route::resource('roles', 'RoleController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // USERS
    // -------------------------------------------------------------------------

    Route::post('users/{uid}/updatePassword', 'UserController@updatePassword');
    Route::post('users/{uid}/resetPassword', 'UserController@resetPassword');
    Route::resource('users', 'UserController', ['only' => [
        'index', 'update',
    ]]);

    // -------------------------------------------------------------------------
    // PROFILES
    // -------------------------------------------------------------------------

    Route::get('profiles/{pid}/conferences', 'ProfileController@conferences');
    Route::get('profiles/{pid}/events', 'ProfileController@events');
    Route::get('profiles/{pid}/rooms', 'ProfileController@rooms');
    Route::get('profiles/{pid}/conferences/vehicles', 'ProfileController@conferenceVehicles');
    Route::get('profiles/{pid}/events/vehicles', 'ProfileController@eventVehicles');
    Route::resource('users.profiles', 'ProfileController', ['only' => [
        'index', 'store', 'update', 'destroy',
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

    Route::get('events/status/{status}', 'EventController@indexWithStatus');
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
        'index', 'store', 'update', 'destroy',
    ]]);

    Route::resource('rooms.guests', 'RoomGuestController', ['only' => [
        'index', 'store', 'destroy',
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

    Route::resource('conferences.vehicles.passengers', 'ConferencePassengerController', ['only' => [
        'index', 'store', 'destroy',
    ]]);

    Route::resource('events.vehicles.passengers', 'EventPassengerController', ['only' => [
        'index', 'store', 'destroy',
    ]]);

    // -------------------------------------------------------------------------
    // MANAGERS
    // -------------------------------------------------------------------------

    Route::resource('conferences.managers', 'ConferenceManagerController', ['only' => [
        'index', 'store', 'destroy',
    ]]);

    Route::resource('events.managers', 'EventManagerController', ['only' => [
        'index', 'store', 'destroy',
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
