<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    protected $fillable = [
        'name',
        'start_date',
        'end_date',
        'address',
        'city',
        'country',
        'attendee_count',
        'capacity',
        'status',
        'description'
    ];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory');
    }

    public function accommodations()
    {
        return $this->belongsToMany('App\Models\Accommodation', 'conference_accommodations');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'conference_vehicles');
    }

    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_conferences');
    }

    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_conferences');
    }
}
