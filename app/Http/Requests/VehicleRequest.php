<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VehicleRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['vehicle.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['vehicle.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['vehicle.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['vehicle.destroy']);
                    break;
                default:
                    return false;
                    break;
            }
        }
    }

    public function createRules()
    {
        return [
            'name'     => ['required', 'string', 'max:255'],
            'capacity' => ['required', 'integer', 'min:1'],
        ];
    }

    public function updateRules()
    {
        return [
            'name'     => ['string', 'max:255'],
            'capacity' => ['integer', 'min:1'],
        ];
    }
}
