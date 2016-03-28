<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ProfileRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['profile.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['profile.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['profile.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['profile.destroy']);
                    break;
                default:
                    return false;
                    break;
            }
        }
    }

    public function createRules()
    {
        return [
            'email'       => ['email', 'max:255'],
            'phone'       => ['integer'],
            'first_name'  => ['required', 'string', 'max:255', $this->NAME],
            'middle_name' => ['string', 'max:255', $this->NAME],
            'last_name'   => ['required', 'string', 'max:255', $this->NAME],
            'city'        => ['string', 'max:255'],
            'country'     => ['string', 'max:255'],
            'birthdate'   => ['required', 'date', 'before:today'],
            'gender'      => ['required', 'string', 'max:255'],
        ];
    }

    public function updateRules()
    {
        return [
            'email'       => ['email', 'max:255'],
            'phone'       => ['integer'],
            'first_name'  => ['string', 'max:255', $this->NAME],
            'middle_name' => ['string', 'max:255', $this->NAME],
            'last_name'   => ['string', 'max:255', $this->NAME],
            'city'        => ['string', 'max:255'],
            'country'     => ['string', 'max:255'],
            'birthdate'   => ['date', 'before:today'],
            'gender'      => ['string', 'max:255'],
        ];
    }
}
