<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

use Sentinel;

use App\Models\User;

abstract class Request extends FormRequest
{
    /**
     * Regex that checks for non-consecutive hyphens and commas.
     *
     * @var string
     */
    protected $NAME = 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/';

    /**
     * Regex that checks for no space at either end and no consecutive spaces.
     *
     * @var string
     */
    protected $NUMBER = 'regex:/.*[0-9]+.*/';

    /**
     * Regex that checks for at least one number.
     *
     * @var string
     */
    protected $SPACES = 'regex:/^\S+(?: \S+)*$/';

    /**
     * Check if the API token in the request matches the API token in the database.
     *
     * @return bool
     */
    public function authenticate()
    {
        $userId = $this->header('ID');
        $apiToken = $this->header('X-Auth-Token');
        if ($userId && $apiToken) {
            $user = Sentinel::findById($userId);
            return $user->api_token == $apiToken;
        }
        return false;
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
        return false;
    }

    /**
     * Check if the authenticated user is a System Administrator.
     *
     * @return bool
     */
    public function isSuperuser()
    {
        if ($this->getUser()) {
            $role = $this->getUser()->roles()->first();
            return $role->name == 'System Administrator';
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
