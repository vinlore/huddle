<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegisterUserRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username'      => ['required', 'min:4', 'alpha_dash', 'unique:users'],
            'password'      => ['required', 'confirmed', 'min:8', 'alpha_dash', 'regex:/^\S+(?: \S+)*$/', 'regex:/.*[0-9]+.*/'],
            'first_name'    => ['required', 'string', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
            'middle_name'   => ['string', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
            'last_name'     => ['required', 'string', 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/'],
            'gender'        => ['string'],
            'birthdate'     => ['date'],
            'country'       => ['string'],
            'city'          => ['string'],
            'email'         => ['email', 'max:255', 'unique:users'],
            'phone'         => ['integer'],
            // 'receive_email' => ['required', 'boolean'],
        ];
    }
}
