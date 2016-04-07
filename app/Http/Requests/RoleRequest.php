<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['role.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['role.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['role.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['role.destroy']);
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
            'slug'        => ['string', 'max:255', 'unique:roles'],
            'name'        => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'array'],
        ];
    }

    public function updateRules()
    {
        return [
            'slug'        => ['string', 'max:255'],
            'name'        => ['string', 'max:255'],
            'permissions' => ['array'],
        ];
    }
}
