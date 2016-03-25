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
        // No space at either end and no consecutive spaces.
        $PASSWORD_SPACES = 'regex:/^\S+(?: \S+)*$/';

        // At least one number.
        $PASSWORD_NUMBER = 'regex:/.*[0-9]+.*/';

        // Allow non-consecutive hyphens and commas.
        $NAME = 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/';

        return [
            'username'      => ['required', 'min:4', 'alpha_dash', 'unique:users'],
            'password'      => ['required', 'confirmed', 'min:8', 'alpha_dash', $PASSWORD_SPACES, $PASSWORD_NUMBER],
            'first_name'    => ['required', 'string', $NAME],
            'middle_name'   => ['string', $NAME],
            'last_name'     => ['required', 'string', $NAME],
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
