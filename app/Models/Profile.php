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

    public function vehicles()
    {
        return $this->belongsToMany('App\Models\Vehicle', 'profile_rides_vehicles')->withTimestamps();
    }
}
