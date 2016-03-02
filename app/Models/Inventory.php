<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    // Each inventory belongs to one conference.
    public function conference() {

    }

    // Each inventory has many items.
    public function items() {

    }

    // Each inventory has many managers.
    public function managers() {

    }
}
