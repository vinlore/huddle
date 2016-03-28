<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventRequest extends Request
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
                    return $this->getUser()->hasAccess(['event.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['event.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['event.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['event.destroy']);
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
         return [
        //     'name'         => ['required', 'string', 'max:255'],
        //     'description'  => ['string'],
        //     'facilitator'  => ['string', 'max:255'],
        //     'date'         => ['required', 'after:yesterday'],
        //     'start_time'   => ['required', 'date_format:H:i', 'after:yesterday'],
        //     'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
        //     'address'      => ['required', 'string', 'max:255'],
        //     'city'         => ['required', 'string', 'max:255'],
        //     'country'      => ['required', 'string', 'max:255'],
        //     'age_limit'    => ['string', 'max:255'],
        //     'gender_limit' => ['string', 'max:255'],
        //     'capacity'     => ['required', 'integer', 'min:1'],
            'name'         => ['required', 'string', 'max:255'],
            'description'  => ['string'],
            'facilitator'  => ['string', 'max:255'],
            'date'         => ['required', 'after:yesterday'],
            'start_time'   => ['required', 'date_format:H:i', 'after:yesterday'],
            'end_time'     => ['required', 'date_format:H:i', 'after:start_time'],
            'address'      => ['required', 'string', 'max:255'],
            'city'         => ['required', 'string', 'max:255'],
            'country'      => ['required', 'string', 'max:255'],
            'age_limit'    => ['string', 'max:255'],
            'gender_limit' => ['string', 'max:255'],
            'capacity'     => ['required', 'integer', 'min:1'],
        ];
    }
}
