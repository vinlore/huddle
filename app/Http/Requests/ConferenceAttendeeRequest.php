<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ConferenceAttendeeRequest extends Request
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
            'email'              => ['email', 'max:255'],
            'phone'              => ['required', 'integer'],
            'phone2'             => ['integer'],
            'first_name'         => ['required', 'string', 'max:255', $NAME],
            'middle_name'        => ['string', 'max:255', $NAME],
            'last_name'          => ['required', 'string', 'max:255', $NAME],
            'city'               => ['string', 'max:255'],
            'country'            => ['string', 'max:255'],
            'birthdate'          => ['required', 'date', 'before:today'],
            'gender'             => ['required', 'string', 'max:255'],
            'accommodation_req'  => ['required', 'boolean'],
            'accommodation_pref' => ['string', 'max:255'],
            'arrv_ride_req'      => ['required', 'boolean'],
            'arrv_date'          => ['required_if:arrv_ride_req,1', 'date', 'after:today'],
            'arrv_time'          => ['required_if:arrv_ride_req,1', 'date_format:H:i', 'after:today'],
            'arrv_airport'       => ['required_if:arrv_ride_req,1', 'string', 'max:255'],
            'arrv_flight'        => ['required_if:arrv_ride_req,1', 'string', 'max:255'],
            'dept_ride_req'      => ['required', 'boolean'],
            'dept_date'          => ['required_if:dept_ride_req,1', 'date', 'after:today'],
            'dept_time'          => ['required_if:dept_ride_req,1', 'date_format:H:i', 'after:today'],
            'dept_airport'       => ['required_if:dept_ride_req,1', 'string', 'max:255'],
            'dept_flight'        => ['required_if:dept_ride_req,1', 'string', 'max:255'],
            'contact_first_name' => ['string', 'max:255'],
            'contact_last_name'  => ['string', 'max:255'],
            'contact_email'      => ['email', 'max:255'],
            'contact_phone'      => ['integer'],
            'medical_conditions' => ['string', 'max:255'],
        ];
    }
}
