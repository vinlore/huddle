<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    // Each event belongs to one conference.
    public function conference() {

    }

    // Each event has many managers.
    public function managers() {

    }

    // Each conference has many attendees.
    public function attendees() {

    }
}
