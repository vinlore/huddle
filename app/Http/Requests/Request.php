<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use App\Models\User;

abstract class Request extends FormRequest
{
    /**
     * Common rules for all requests.
     *
     * @var array
     */
    protected $rules = [];

    /**
     * Rules for create requests.
     *
     * @var array
     */
    protected $createRules = [];

    /**
     * Rules for update requests.
     *
     * @var array
     */
    protected $updateRules = [];

    /**
     * Check if the API token in the request matches the API token in the database.
     *
     * @return bool
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
     *
     * @return Eloquent\Model
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
     *
     * @return bool
     */
    public function isSuperuser()
    {
        $role = $this->getUser()->roles()->first();
        return $role->name == 'System Administrator';
    }
}
