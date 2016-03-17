<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vehicle extends Model
{
    protected $fillable = [
        'name',
        'passenger_count',
        'capacity',
    ];

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'conference_vehicles');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'event_vehicles');
    }

    public function passengers()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_rides_vehicles');
    }
}
