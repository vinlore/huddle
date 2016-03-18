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
        return $this->belongsToMany('App\Models\Accommodation', 'conference_accommodations');
    }

    public function inventory()
    {
        return $this->hasOne('App\Models\Inventory');
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
