<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventAttendeeRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return true;
                    break;
                case 'GET':
                    return true;
                    break;
                case 'PUT':
                    return true;
                    break;
                case 'DELETE':
                    return true;
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
            'arrv_ride_req' => ['required', 'boolean'],
            'dept_ride_req' => ['required', 'boolean'],
            'status'        => ['string', 'in:pending']
        ];
    }

    public function updateRules()
    {
        return [
            'arrv_ride_req' => ['boolean'],
            'dept_ride_req' => ['boolean'],
        ];
    }
}
