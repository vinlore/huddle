<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Conference extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'address',
        'city',
        'country',
        'attendee_count',
        'capacity',
        'status',
    ];

    protected $dates = ['deleted_at'];

    public function events()
    {
        return $this->hasMany('App\Models\Event');
    }

    public function accommodations()
    {
        return $this->hasMany('App\Models\Accommodation');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function vehicles()
    {
        return $this->hasMany('App\Models\ConferenceVehicle');
    }

    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_conferences')->withTimestamps();
    }

    public function attendees()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_attends_conferences')->withTimestamps()
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

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($conference) {
            foreach ($conference->events as $event) {
                $event->delete();
            }
            foreach ($conference->accommodations as $accommodation) {
                $accommodation->delete();
            }
            foreach ($conference->items as $item) {
                $item->delete();
            }
            foreach ($conference->vehicles as $vehicle) {
                $vehicle->delete();
            }
            $conference->managers()->detach();
            $conference->attendees()->detach();
        });
    }
}
