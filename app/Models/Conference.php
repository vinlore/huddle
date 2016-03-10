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
        'inventory_id',
        'status'
    ];



    // Each conference has one inventory.
    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory');
    }

    // Each conference has many accommodations.
    public function accommodations()
    {
        return $this->belongsToMany('App\Models\Accommodation');
    }

    // Each conference has many transportation options.
    public function transportation()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'conference_vehicles');
    }

    // Each conference has many flights.
    public function flights()
    {
        return $this->hasMany('App\Models\Flight');
    }

    // Each conference has many events.
    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    // Each conference has many managers.
    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_conferences');
    }

    // Each conference has many attendees.
    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_conferences');
    }
}
