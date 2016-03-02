<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Accommodation extends Model
{
    // Each accommodation has many rooms.
    public function rooms() {

    }

    // Each accommodation belongs to many conferences.
    public function conferences() {

    }
}
