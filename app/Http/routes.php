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

    Route::resource('events', 'EventController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('accommodations', 'AccommodationController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('rooms', 'RoomController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('items', 'ItemController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('vehicles', 'VehicleController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
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
