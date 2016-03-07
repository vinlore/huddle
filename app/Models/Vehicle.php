<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    // Each vehicle belongs to many conferences.
    public function conferences()
    {
        return $this->belongToMany('App\Models\Conference', 'conference_vehicles');
    }

    // Each vehicle belongs to many events.
    public function events()
    {
        return $this->belongToMany('App\Models\Event', 'event_vehicles');
    }

    // Each vehicle takes many passengers.
    public function passengers()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_rides_vehicles');
    }
}
