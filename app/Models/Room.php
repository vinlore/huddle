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

    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }

    public function guests()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_stays_in_rooms')->withTimestamps();
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($room) {
            $room->guests()->detach();
        });
    }
}
