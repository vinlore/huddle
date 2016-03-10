<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
    protected $table = 'inventories';

    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    public function items()
    {
        return $this->hasMany('App\Models\Item');
    }

    public function managers()
    {
        return $this->belongsToMany('App\Models\User', 'user_manages_inventories');
    }
}
