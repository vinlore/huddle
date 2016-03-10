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

    public function role()
    {
        return $this->belongsTo('App\Models\Role');
    }

    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Confernece', 'user_manages_conferences');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'user_manages_events');
    }

    public function inventories()
    {
        return $this->belongsToMany('App\Models\Inventory', 'user_manages_inventories');
    }
}
