<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ResetPasswordRequest extends Request
{
    public function authorize()
    {
        return $this->isSuperuser();
    }

    public function commonRules()
    {
        return [
            'new_password' => ['required', 'confirmed', 'min:8', 'alpha_dash', self::SPACES, self::LETTER, self::NUMBER],
        ];
    }
}
