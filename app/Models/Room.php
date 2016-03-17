<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
	protected $fillable = [
        'accomodation_id',
        'room_no',
        'guest_count',
        'capacity',
    ];

    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }

    public function guests()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_stays_in_rooms');
    }
}
