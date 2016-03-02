<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Each room belongs to one accommodation.
    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }

    // Each room has many guests.
    public function guests()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_stays_in_rooms');
    }
}
