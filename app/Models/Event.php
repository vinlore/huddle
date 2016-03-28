<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Event extends Model
{
    use SoftDeletes;

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
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'event_vehicles')->withTimestamps();
    }

    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_events')->withTimestamps();
    }

    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_events')->withTimestamps()
                    ->withPivot('arrv_ride_req',
                                'dept_ride_req',
                                'status');
    }
}
