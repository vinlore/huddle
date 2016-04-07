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

    protected $hidden = [
        'arrv_date',
        'arrv_time',
        'arrv_airport',
        'arrv_flight',
        'dept_date',
        'dept_time',
        'dept_airport',
        'dept_flight',
    ];

    protected $appends = [
        'arrv_date',
        'arrv_time',
        'arrv_airport',
        'arrv_flight',
        'dept_date',
        'dept_time',
        'dept_airport',
        'dept_flight',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'profile_attends_conferences')
                    ->withTimestamps()
                    ->withPivot('email',
                                'phone',
                                'phone2',
                                'first_name',
                                'middle_name',
                                'last_name',
                                'city',
                                'country',
                                'birthdate',
                                'gender',
                                'accommodation_req',
                                'accommodation_pref',
                                'arrv_ride_req',
                                'arrv_date',
                                'arrv_time',
                                'arrv_airport',
                                'arrv_flight',
                                'dept_ride_req',
                                'dept_date',
                                'dept_time',
                                'dept_airport',
                                'dept_flight',
                                'contact_first_name',
                                'contact_last_name',
                                'contact_email',
                                'contact_phone',
                                'medical_conditions',
                                'status');
    }

    public function events()
    {
        return $this->belongsToMany('App\Models\Event', 'profile_attends_events')
                    ->withTimestamps()
                    ->withPivot('arrv_ride_req',
                                'dept_ride_req',
                                'status');
    }

    public function rooms()
    {
        return $this->belongsToMany('App\Models\Room', 'profile_stays_in_rooms')->withTimestamps();
    }

    public function conferenceVehicles()
    {
        return $this->belongsToMany('App\Models\ConferenceVehicle', 'conference_vehicle_passengers', 'profile_id', 'vehicle_id')->withTimestamps();
    }

    public function eventVehicles()
    {
        return $this->belongsToMany('App\Models\EventVehicle', 'event_vehicle_passengers', 'profile_id', 'vehicle_id')->withTimestamps();
    }

    // -------------------------------------------------------------------------
    // FLIGHT INFORMATION
    // -------------------------------------------------------------------------

    public function getArrvDateAttribute()
    {
        return $this->attributes['arrv_date'];
    }

    public function getArrvTimeAttribute()
    {
        return $this->attributes['arrv_time'];
    }

    public function getArrvAirportAttribute()
    {
        return $this->attributes['arrv_airport'];
    }

    public function getArrvFlightAttribute()
    {
        return $this->attributes['arrv_flight'];
    }

    public function getDeptDateAttribute()
    {
        return $this->attributes['dept_date'];
    }

    public function getDeptTimeAttribute()
    {
        return $this->attributes['dept_time'];
    }

    public function getDeptAirportAttribute()
    {
        return $this->attributes['dept_airport'];
    }

    public function getDeptFlightAttribute()
    {
        return $this->attributes['dept_flight'];
    }
}
