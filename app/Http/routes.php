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

    Route::resource('roles' , 'RoleController', ['only' =>[
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('users', 'UserController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('users.profiles', 'ProfileController', ['only' => [
        'index', 'store', 'update', 'destroy',
    ]]);

    Route::resource('conferences', 'ConferenceController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('events', 'EventController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('accommodations', 'AccommodationController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('rooms', 'RoomController', ['only' => [
        'index', 'store', 'show', 'update', 'destroy',
    ]]);

    Route::resource('inventories', 'InventoryController', ['only' => [
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


// Assign the 'Admin' role to the first user.
Route::get('assignRole', function () {
    $user = Sentinel::findById(21);
    $role = Sentinel::findRoleByName('Reg');
    $role->users()->attach($user);
    var_dump($role);
});

// Remove the 'Admin' role from the first user.
Route::get('removeRole', function () {
    $user = Sentinel::findById(1);
    $role = Sentinel::findRoleByName('Admin');
    $role->users()->detach($user);
    var_dump($role);
});

Route::get('addRole', function(){
    $role = \Sentinel::getRoleRepository()->createModel()->create([
            'name' => 'Reg',
            'slug' => 'reg',
        ]);
});

// Add permissions to the 'Admin' role.
Route::get('addPermissions', function () {
    $role = Sentinel::findRoleByName('Admin');
    $role->permissions = [
        'event.update' => true,
        'event.view'   => false,
    ];
    $role->save();
    var_dump($role);
});

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
