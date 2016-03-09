<?php

// -----------------------------------------------------------------------------
// API
// -----------------------------------------------------------------------------

// Prefix all API routes with 'api'.
Route::group(['prefix' => 'api', 'middleware' => ['throttle:50,1',]], function () {
    Route::post('create', 'UserController@user_registration');
    Route::post('auth', 'UserController@user_authentication');
    Route::post('logout', 'UserController@logout');

    Route::resource('conferences', 'ConferenceController');
});

// -----------------------------------------------------------------------------
// TESTING
// -----------------------------------------------------------------------------

// Test DDoS protection.
// throttle{requests/minute}
Route::get('api/ddos', ['middleware' => 'throttle:10,1', function () {
    return 'Hello!';
}]);

// Create a role called 'Admin'.
Route::get('createRole', function () {
    $role = Sentinel::getRoleRepository()->createModel()->create([
        'name' => 'Admin',
        'slug' => 'Admin',
    ]);
    var_dump($role);
});

// Assign the 'Admin' role to the first user.
Route::get('assignRole', function () {
    $user = Sentinel::findById(1);
    $role = Sentinel::findRoleByName('Admin');
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
