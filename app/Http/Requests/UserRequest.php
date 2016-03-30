<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class UserRequest extends Request
{
    public function authorize()
    {
        if ($this->isSuperuser()) {
            return true;
        }

        if ($this->authenticate()) {
            switch (strtoupper($this->getMethod())) {
                case 'POST':
                    return $this->getUser()->hasAccess(['user.store']);
                    break;
                case 'GET':
                    return $this->getUser()->hasAccess(['user.show']);
                    break;
                case 'PUT':
                    return $this->getUser()->hasAccess(['user.update']);
                    break;
                case 'DELETE':
                    return $this->getUser()->hasAccess(['user.destroy']);
                    break;
                default:
                    break;
            }
        }

        return false;
    }
}
