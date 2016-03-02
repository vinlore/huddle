<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    // Each item belongs to one inventory.
    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory');
    }
}
