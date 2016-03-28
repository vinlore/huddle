<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ItemRequest extends Request
{
    protected $createRules = [
        'name'     => ['required', 'string', 'max:255'],
        'quantity' => ['required', 'string', 'min:0'],
    ];

    protected $updateRules = [
        'name'     => ['string', 'max:255'],
        'quantity' => ['string', 'min:0'],
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
                    return $this->getUser()->hasAccess(['item.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['item.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['item.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['item.destroy']);
                    break;
                default:
                    return false;
                    break;
            }
        }
    }
}
