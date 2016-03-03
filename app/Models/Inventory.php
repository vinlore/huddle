<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    // Each inventory belongs to one conference.
    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    // Each inventory has many items.
    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    // Each inventory has many managers.
    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_inventories');
    }
}
