<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ConferenceVehicle extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'event_id',
        'name',
        'type',
        'passenger_count',
        'capacity',
    ];

    protected $dates = ['deleted_at'];

    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    public function passengers()
    {
        return $this->belongsToMany('App\Models\Profile', 'conference_vehicle_passengers')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($vehicle) {
            $vehicle->passengers()->detach();
        });
    }
}
