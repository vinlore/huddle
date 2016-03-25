<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ItemRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
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

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }
}
