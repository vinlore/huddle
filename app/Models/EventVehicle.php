<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EventVehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conference_id',
        'name',
        'type',
        'passenger_count',
        'capacity',
    ];

    protected $dates = ['deleted_at'];

    public function event()
    {
        return $this->belongsTo('App\Models\Event');
    }

    public function passengers()
    {
        return $this->belongsToMany('App\Models\Profile', 'event_vehicle_passengers', 'vehicle_id')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($vehicle) {
            $vehicle->passengers()->detach();
        });
    }
}
