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
            'password'      => ['required', 'confirmed', 'min:8', 'alpha_dash', self::SPACES, self::LETTER, self::NUMBER],
            'first_name'    => ['required', 'string', 'max:255', self::NAME],
            'middle_name'   => ['string', 'max:255', self::NAME],
            'last_name'     => ['required', 'string', 'max:255', self::NAME],
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
