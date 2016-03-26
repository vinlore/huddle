<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class EventAttendeeRequest extends Request
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
