<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Accommodation extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'conference_id',
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

    public function conference()
    {
        return $this->belongsTo('App\Models\Conference');
    }

    protected static function boot()
    {
        parent::boot();
        static::deleting(function ($accommodation) {
            foreach ($accommodation->rooms as $room) {
                $room->delete();
            }
        });
    }
}
