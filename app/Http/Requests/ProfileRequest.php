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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        // Allow non-consecutive hyphens and commas.
        $NAME = 'regex:/^[A-Za-z,]+([?: |\-][A-Za-z,]+)*[^\,]$/';

        return [
            'email'       => ['email', 'max:255'],
            'phone'       => ['integer'],
            'first_name'  => ['required', 'string', 'max:255', $NAME],
            'middle_name' => ['string', 'max:255', $NAME],
            'last_name'   => ['required', 'string', 'max:255', $NAME],
            'city'        => ['string', 'max:255'],
            'country'     => ['string', 'max:255'],
            'birthdate'   => ['required', 'date', 'before:today'],
            'gender'      => ['required', 'string', 'max:255'],
        ];
    }
}
