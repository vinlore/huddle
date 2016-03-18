<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Profile extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'is_owner',
        'email',
        'phone',
        'first_name',
        'middle_name',
        'last_name',
        'city',
        'country',
        'birthdate',
        'gender',
    ];

    protected $dates = ['deleted_at'];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'profile_attends_conferences');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'profile_attends_events');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room', 'profile_stays_in_rooms');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'profile_rides_vehicles');
    }
}
