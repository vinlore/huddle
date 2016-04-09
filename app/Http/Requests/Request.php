<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Sentinel;

abstract class Request extends FormRequest
{
    /**
     * Regex that checks for non-consecutive hyphens and commas.
     */
    const NAME = 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/';

    /**
     * Regex that checks for no space at either end and no consecutive spaces.
     */
    const SPACES = 'regex:/.*[0-9]+.*/';

    /**
     * Regex that checks for at least one letter.
     */
    const LETTER = 'regex:/^\d*[a-zA-Z][a-zA-Z0-9]*$/';

    /**
     * Regex that checks for at least one number.
     */
    const NUMBER = 'regex:/^\S+(?: \S+)*$/';

    /**
     * Verify the legitimacy of the API token.
     *
     * @return bool
     */
    public function authenticate()
    {
        $uid = $this->header('ID');
        $token = $this->header('X-Auth-Token');
        $user = Sentinel::findById($uid);
        if ($user) {
            return $user->api_token == $token;
        }
        return false;
    }

    /**
     * Retrieve the authenticated User.
     *
     * @return App\Models\User|bool
     */
    public function getUser()
    {
        if ($this->authenticate()) {
            $uid = $this->header('ID');
            return Sentinel::findById($uid);
        }
        return false;
    }

    /**
     * Check if the User is a System Administrator.
     *
     * @return bool
     */
    public function isSuperuser()
    {
        if ($this->getUser()) {
            $role = $this->getUser()->roles()->first();
            return $role->getKey() == 1;
        }
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch (strtoupper($this->getMethod())) {
            case 'POST':
                return array_merge($this->commonRules(), $this->createRules());
                break;
            case 'PUT':
                return array_merge($this->commonRules(), $this->updateRules());
                break;
            default:
                return [];
                break;
        }
    }

    /**
     * Get the validation rules that apply to all requests.
     *
     * @return array
     */
    public function commonRules()
    {
        return [];
    }

    /**
     *  Get the validation rules that apply to create requests.
     *
     * @return array
     */
    public function createRules()
    {
        return [];
    }

    /**
     *  Get the validation rules that apply to update requests.
     *
     * @return array
     */
    public function updateRules()
    {
        return [];
    }
}
