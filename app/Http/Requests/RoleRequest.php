<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RoleRequest extends Request
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
            'slug'        => ['required', 'string', 'max:255', 'unique:roles'],
            'name'        => ['required', 'string', 'max:255', 'unique:roles'],
            'permissions' => ['required', 'string', 'unique:roles'],
        ];
    }
}
