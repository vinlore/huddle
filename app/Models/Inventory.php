<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Inventory extends Model
{
    use SoftDeletes;

    protected $table = 'inventories';

    protected $fillable = [
        'conference_id',
    ];

    protected $dates = ['deleted_at'];

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
