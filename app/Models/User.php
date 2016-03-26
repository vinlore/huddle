<?php

namespace App\Models;

use Cartalyst\Sentinel\Users\EloquentUser;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends EloquentUser
{
    use SoftDeletes;

    protected $loginNames = ['username'];

    protected $fillable = [
        'username',
        'email',
        'password',
        'permissions',
    ];

    protected $dates = ['deleted_at'];

    public function profiles()
    {
        return $this->hasMany('App\Models\Profile');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'user_manages_conferences')->withTimestamps();
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'user_manages_events')->withTimestamps();
    }

    public function activities()
    {
        return $this->hasMany('App\Models\Activity');
    }
}
