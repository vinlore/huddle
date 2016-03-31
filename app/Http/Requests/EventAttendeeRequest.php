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
                    return $this->getUser()->hasAccess(['event_attendee.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['event_attendee.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['event_attendee.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['event_attendee.destroy']);
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
