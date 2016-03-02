<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Conference extends Model
{
    // Each conference has one inventory.
    public function inventory() {

    }

    // Each conference has many accommodations.
    public function accommodations() {

    }

    // Each conference has many events.
    public function events() {

    }

    // Each conference has many managers.
    public function managers() {

    }

    // Each conference has many attendees.
    public function attendees() {

    }
}
