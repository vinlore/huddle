<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Activity extends Model
{
     use SoftDeletes;

    protected $fillable = [
        'user_id',
        'activity_type',
        'source_id',
        'source_type'
    ];

    protected $dates = ['deleted_at'];

      public function user()
    {
        return $this->hasOne('App\Models\User');
    }

}
