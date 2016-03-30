<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoomRequest extends Request
{
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
                    break;
            }
        }

        return false;
    }

    public function createRules()
    {
        return [
            'room_no'  => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function updateRules()
    {
        return [
            'room_no'  => ['string', 'max:255'],
            'capacity' => ['integer', 'min:1'],
        ];
    }
}
