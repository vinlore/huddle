<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class VehicleRequest extends Request
{
    protected $createRules = [
        'name'     => ['required', 'string', 'max:255'],
        'capacity' => ['required', 'integer', 'min:1'],
    ];

    protected $updateRules = [
        'name'     => ['string', 'max:255'],
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
}
