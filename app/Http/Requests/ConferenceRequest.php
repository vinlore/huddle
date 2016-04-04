<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConferenceRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['conference.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['conference.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['conference.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['conference.destroy']);
                    break;
                default:
                    break;
            }
        }

        return false;
    }

    public function createRules()
    {
        return [
            'name'        => ['required', 'string', 'max:255'],
            'description' => ['string'],
            'start_date'  => ['required', 'date', 'after:yesterday'],
            'end_date'    => ['required', 'date', 'after:start_date'],
            'address'     => ['required', 'string', 'max:255'],
            'city'        => ['required', 'string', 'max:255'],
            'country'     => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'status'      => ['string', 'in:pending'],
        ];
    }

    public function updateRules()
    {
        return [
            'name'        => ['string', 'max:255'],
            'description' => ['string'],
            'start_date'  => ['date'],
            'end_date'    => ['date', 'after:start_date'],
            'address'     => ['string', 'max:255'],
            'city'        => ['string', 'max:255'],
            'country'     => ['string', 'max:255'],
            'capacity'    => ['integer', 'min:1'],
            'status'      => ['string', 'in:pending,approved,denied'],
        ];
    }
}
