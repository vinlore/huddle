<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accommodation extends Model
{
    use SoftDeletes;

	protected $fillable = [
        'name',
        'address',
        'city',
        'country',
    ];

    protected $dates = ['deleted_at'];

    public function rooms()
    {
        return $this->hasMany('App\Models\Room');
    }

    public function conferences()
    {
        return $this->belongsToMany('App\Models\Conference', 'conference_accommodations');
    }
}
