<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventAttendeeRequest extends Request
{
    public function authorize()
    {
        return true;
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
