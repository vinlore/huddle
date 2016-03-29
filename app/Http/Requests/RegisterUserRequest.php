<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterUserRequest extends Request
{
    public function authorize()
    {
        return true;
    }

    public function commonRules()
    {
        return [
            'username'      => ['required', 'min:4', 'alpha_dash', 'unique:users'],
            'password'      => ['required', 'confirmed', 'min:8', 'alpha_dash', $this->NUMBER, $this->SPACES],
            'first_name'    => ['required', 'string', 'max:255', $this->NAME],
            'middle_name'   => ['string', 'max:255', $this->NAME],
            'last_name'     => ['required', 'string', 'max:255', $this->NAME],
            'gender'        => ['required', 'string', 'max:255'],
            'birthdate'     => ['required', 'date', 'before:today'],
            'country'       => ['string', 'max:255'],
            'city'          => ['string', 'max:255'],
            'email'         => ['email', 'max:255', 'unique:users'],
            'receive_email' => ['required', 'boolean'],
            'phone'         => ['integer'],
        ];
    }
}
