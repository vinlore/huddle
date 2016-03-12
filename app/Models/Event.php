<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    protected $fillable = [
        'conference_id',
        'name',
        'description',
        'facilitator',
        'date',
        'start_time',
        'end_time',
        'address',
        'city',
        'country',
        'age_limit',
        'gender_limit',
        'attendee_count',
        'capacity',
        'status'
    ];

    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'event_vehicles');
    }

    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_events');
    }

    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_events');
    }
}
