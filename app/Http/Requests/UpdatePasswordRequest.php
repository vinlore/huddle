<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UpdatePasswordRequest extends Request
{
    public function authorize()
    {
        return $this->authenticate();
    }

    public function commonRules()
    {
        return [
            'old_password' => ['required', 'min:8', 'alpha_dash', $this->SPACES, $this->LETTER, $this->NUMBER],
            'new_password' => ['required', 'confirmed', 'min:8', 'alpha_dash', $this->SPACES, $this->LETTER, $this->NUMBER],
        ];
    }
}
