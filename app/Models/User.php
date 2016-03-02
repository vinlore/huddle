<?php
namespace app\Models;
use Cartalyst\Sentinel\Users\EloquentUser as SentinelUser;


class User extends SentinelUser {

    protected $fillable = [
        'email',
        'username',
        'password',
        'first_name',
        'last_name',
        'permissions',
    ];

    protected $loginNames = ['username'];
}
?>
