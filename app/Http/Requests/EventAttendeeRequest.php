<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventAttendeeRequest extends Request
{
    protected $createRules = [
        'arrv_ride_req' => ['required', 'boolean'],
        'dept_ride_req' => ['required', 'boolean'],
    ];

    protected $updateRules = [
        'arrv_ride_req' => ['boolean'],
        'dept_ride_req' => ['boolean'],
    ];

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
                    return false;
                    break;
            }
        }
    }
}
