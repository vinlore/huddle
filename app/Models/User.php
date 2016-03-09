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
    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }

    // Each user manages many conferences.
    public function conferences()
    {
        return $this->belongsToMany('App\Models\Confernece', 'user_manages_conferences');
    }

    // Each user manages many events.
    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'user_manages_events');
    }

    // Each user manages many inventories.
    public function inventories()
    {
        return $this->belongsToMany('App\Models\Inventory', 'user_manages_inventories');
    }

    // Each user has one role.
    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }
}
