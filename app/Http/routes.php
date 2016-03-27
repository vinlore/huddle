<?php

// -----------------------------------------------------------------------------
// API
// -----------------------------------------------------------------------------

Route::get('syslogs', '\Rap2hpoutre\LaravelLogViewer\LogViewerController@index');

// Routes that don't require the user to be logged in.
Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {
    Route::post('auth/register', 'AuthController@signup');
    Route::post('auth/login', 'AuthController@signin');
    Route::post('auth/logout', 'AuthController@signout');
});


// Prefix all API routes with 'api'. - TODO - Make sure to add, AuthToken
Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1']], function () {

    Route::post('auth/confirm', 'AuthController@confirm');

    Route::get('activity', 'ActivityController@get');

    //============ Accomodation Controller ============
    Route::resource('accommodation', 'AccommodationController', ['only' => [
        'store', 'show', 'update', 'destroy',
    ]]);

    //============ Conference Controller ============
    Route::put('conferences-status/{id}', 'ConferenceController@updateWithStatus');
    Route::get('conferences-status' , 'ConferenceController@indexWithStatus');

    Route::resource('conferences', 'ConferenceController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);
    //============

    //============ Event Controller ============
    Route::resource('conferences.events', 'EventController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    Route::put('events-status/{id}', 'EventController@updateWithStatus');
    Route::get('events-status' , 'EventController@indexWithStatus');
    //============

    //============ Item Controller ============
    Route::resource('conferences.inventory', 'ItemController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);


    //============ PIVOT - Profile Attend Conference =====
    Route::resource('conferences.profiles' , 'ProfileAttendsConferenceController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    Route::post('profile.conference.status', 'ProfileAttendsConferenceController@profileConferenceStatusUpdate');
    //============

    //============ PIVOT - Profile Attend Event ========
    Route::resource('profile.event' , 'ProfileAttendsEventController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    Route::post('profile.event.status', 'ProfileAttendsEventController@profileEventStatusUpdate');

    //============

    //============ Profile Controller ============
    Route::resource('users.profiles', 'ProfileController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    Route::get('profile/{id}/conferences', 'ProfileController@allProfileConferences');

    //============ PIVOT - Profile Rides Vehicle ============
    Route::resource('profile.vehicle', 'ProfileRidesVehicleController', ['only' => [
         'show', 'update', 'destroy',
    ]]);

    //============ PIVOT - Profile Stays Room ============
    Route::resource('profile.room', 'ProfileStaysRoomController', ['only' => [
         'show' , 'update', 'destroy',
    ]]);

    //============ Role Controller ============
    Route::resource('roles' , 'RoleController', ['only' =>[
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    //============ Room Controller ============
    Route::resource('accommodations.rooms', 'RoomController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    //============ User Controller ============
    Route::resource('users', 'UserController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::get('users-roles', 'UserController@indexWithRoles');

    //============ PIVOT -  User Manages Conference ============
    Route::resource('conferences.managers' , 'UserManagesConferenceController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    //============ PIVOT -  User Manages Events============
    Route::resource('events.managers' , 'UserManagesEventsController' , ['only' => [
            'index' , 'store' , 'show' ,'update', 'destroy',
    ]]);

    //============ Vehicle Controller ============
    Route::resource('vehicle', 'VehicleController', ['only' => [
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
