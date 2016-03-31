<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConferenceAttendeeRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['conference_attendee.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['conference_attendee.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['conference_attendee.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['conference_attendee.destroy']);
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
            'email'              => ['email', 'max:255'],
            'phone'              => ['required', 'string'],
            'phone2'             => ['string'],
            'first_name'         => ['required', 'string', 'max:255', $this->NAME],
            'middle_name'        => ['string', 'max:255', $this->NAME],
            'last_name'          => ['required', 'string', 'max:255', $this->NAME],
            'city'               => ['string', 'max:255'],
            'country'            => ['string', 'max:255'],
            'birthdate'          => ['required', 'date', 'before:today'],
            'gender'             => ['required', 'string', 'max:255'],
            'accommodation_req'  => ['required', 'boolean'],
            'accommodation_pref' => ['integer'],
            'arrv_ride_req'      => ['required', 'boolean'],
            'arrv_date'          => ['required_if:arrv_ride_req,1', 'date', 'after:today'],
            'arrv_time'          => ['required_if:arrv_ride_req,1', 'date_format:H:i'],
            'arrv_airport'       => ['required_if:arrv_ride_req,1', 'string', 'max:255'],
            'arrv_flight'        => ['required_if:arrv_ride_req,1', 'string', 'max:255'],
            'dept_ride_req'      => ['required', 'boolean'],
            'dept_date'          => ['required_if:dept_ride_req,1', 'date', 'after:arrv_date'],
            'dept_time'          => ['required_if:dept_ride_req,1', 'date_format:H:i'],
            'dept_airport'       => ['required_if:dept_ride_req,1', 'string', 'max:255'],
            'dept_flight'        => ['required_if:dept_ride_req,1', 'string', 'max:255'],
            'contact_first_name' => ['string', 'max:255'],
            'contact_last_name'  => ['string', 'max:255'],
            'contact_email'      => ['email', 'max:255'],
            'contact_phone'      => ['string'],
            'medical_conditions' => ['string', 'max:255'],
            'status'             => ['string', 'in:pending']
        ];
    }

    public function updateRules()
    {
        return [
            'email'              => ['email', 'max:255'],
            'phone'              => ['string'],
            'phone2'             => ['string'],
            'first_name'         => ['string', 'max:255', $this->NAME],
            'middle_name'        => ['string', 'max:255', $this->NAME],
            'last_name'          => ['string', 'max:255', $this->NAME],
            'city'               => ['string', 'max:255'],
            'country'            => ['string', 'max:255'],
            'birthdate'          => ['date', 'before:today'],
            'gender'             => ['string', 'max:255'],
            'accommodation_req'  => ['boolean'],
            'accommodation_pref' => ['string', 'max:255'],
            'arrv_ride_req'      => ['boolean'],
            'arrv_date'          => ['date'],
            'arrv_time'          => ['date_format:H:i'],
            'arrv_airport'       => ['string', 'max:255'],
            'arrv_flight'        => ['string', 'max:255'],
            'dept_ride_req'      => ['boolean'],
            'dept_date'          => ['date', 'after:arrv_date'],
            'dept_time'          => ['date_format:H:i'],
            'dept_airport'       => ['string', 'max:255'],
            'dept_flight'        => ['string', 'max:255'],
            'contact_first_name' => ['string', 'max:255'],
            'contact_last_name'  => ['string', 'max:255'],
            'contact_email'      => ['email', 'max:255'],
            'contact_phone'      => ['string'],
            'medical_conditions' => ['string', 'max:255'],
        ];
    }
}
