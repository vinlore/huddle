<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoomRequest extends Request
{
    protected $createRules = [
        'room_no'  => ['required', 'string', 'max:255'],
        'capacity' => ['required', 'integer', 'min:1'],
    ];

    protected $updateRules = [
        'room_no'  => ['string', 'max:255'],
        'capacity' => ['integer', 'min:1'],
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
                    return $this->getUser()->hasAccess(['room.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['room.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['room.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['room.destroy']);
                    break;
                default:
                    return false;
                    break;
            }
        }
    }
}
