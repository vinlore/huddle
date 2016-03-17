<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'inventory_id',
        'name',
        'quantity',
    ];

    protected $dates = ['deleted_at'];

    public function inventory()
    {
        return $this->belongsTo('App\Models\Inventory');
    }
}
