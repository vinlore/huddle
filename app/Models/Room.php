<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    public function accommodation()
    {
        return $this->belongsTo('App\Models\Accommodation');
    }

    public function guests()
    {
        return $this->belongsToMany('App\Models\Profile', 'profile_stays_in_rooms');
    }
}
