<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

abstract class Request extends FormRequest
{
    /**
     * Check if the API token in the request matches the API token in the database.
     */
    public function authenticate()
    {
        $userId = $this->header('ID');
        $apiToken = $this->header('X-Auth-Token');
        $user = User::find($userId);
        return $user->api_token = $apiToken;
    }

    /**
     * Retrieve the authenticated user.
     */
    public function getUser()
    {
        if ($this->authenticate()) {
            $userId = $this->header('ID');
            $apiToken = $this->header('X-Auth-Token');
            return User::find($userId);
        }
    }

    /**
     * Check if the authenticated user is a System Administrator.
     */
    public function isSuperuser()
    {
        $role = $this->getUser()->roles()->first();
        if ($role->name == 'System Administrator') {
            return true;
        }
        return false;
    }
}
