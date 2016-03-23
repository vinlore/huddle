<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class StoreConferenceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $request->header('ID');
        $api_token = $request->header('X-Auth-Token');

        $user_to_check = User::find($user_id);

        if($user_to_check->api_token == $api_token && $user_to_check->hasAccess(['conference.store']))
            return true;
        else
            return false;
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
