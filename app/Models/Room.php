<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Room extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'accomodation_id',
        'room_no',
        'guest_count',
        'capacity',
    ];

    protected $dates = ['deleted_at'];

    protected $hidden = [
        'conference_id',
        'accommodation_name',
    ];

    protected $appends = [
        'conference_id',
        'accommodation_name',
    ];

    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }

    public function guests()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_stays_in_rooms')->withTimestamps();
    }

    public function conference()
    {
        $accommodation = $this->accommodation();
        return $accommodation->getResults()->belongsTo('App\Models\Conference');
    }

    public function getConferenceIdAttribute()
    {
        return $this->attributes['conference_id'];
    }

    public function getAccommodationNameAttribute()
    {
        return $this->attributes['accommodation_name'];
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($room) {
            $room->guests()->detach();
        });
    }
}
