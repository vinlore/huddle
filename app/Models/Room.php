<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Room extends Model
{
    // Each room belongs to one accommodation.
    public function accommodation() {

    }

    // Each room has many guests.
    public function guests() {

    }
}
