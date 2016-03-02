<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;

class User extends SentinelUser
{
    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'permissions',
    ];

    protected $loginNames = ['username'];

    // Each user has many profiles.
    public function profiles() {

    }

    // Each user manages many conferences.
    public function conferences() {

    }

    // Each user manages many events.
    public function events() {

    }

    // Each user manages many inventories.
    public function inventories() {

    }
}
