<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Profile extends Model
{
    // Each profile belongs to one user.
    public function user() {

    }

    // Each profile attends many conferences.
    public function conferences() {

    }

    // Each profile attends many events.
    public function events() {

    }

    // Each profile stays in many rooms.
    public function rooms() {

    }
}
