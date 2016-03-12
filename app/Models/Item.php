<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
	protected $fillable = [
        'inventory_id',
        'name',
        'quantiy'
    ];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory');
    }
}
