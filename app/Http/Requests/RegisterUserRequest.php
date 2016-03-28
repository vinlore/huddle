<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterUserRequest extends Request
{
    public $rules = [
        'username'      => ['required', 'min:4', 'alpha_dash', 'unique:users'],
        'password'      => ['required', 'confirmed', 'min:8', 'alpha_dash', 'regex:/.*[0-9]+.*/', 'regex:/^\S+(?: \S+)*$/'],
        'first_name'    => ['required', 'string', 'max:255', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
        'middle_name'   => ['string', 'max:255', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
        'last_name'     => ['required', 'string', 'max:255', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
        'gender'        => ['required', 'string', 'max:255'],
        'birthdate'     => ['required', 'date', 'before:today'],
        'country'       => ['string', 'max:255'],
        'city'          => ['string', 'max:255'],
        'email'         => ['email', 'max:255', 'unique:users'],
        'receive_email' => ['required', 'boolean'],
        'phone'         => ['integer'],
    ];

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }
}
