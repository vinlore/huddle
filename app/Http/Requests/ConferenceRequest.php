<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User as User;

class ConferenceRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $user_id = $this->header('ID');
        $api_token = $this->header('X-Auth-Token');
            
        $user_to_check = User::find($user_id);


        if($user_to_check->api_token == $api_token){

            switch (strtoupper($this->getMethod())) {
                case 'POST':
                   if($user_to_check->hasAccess(['conference.store'])){
                        return true;
                   }else{
                        return false;
                   }
                  
                case 'PUT':
                    if($user_to_check->hasAccess(['conference.update'])){
                        return true;
                   }else{
                        return false;
                   }

                case 'DESTROY':
                    if($user_to_check->hasAccess(['conference.destroy'])){
                        return true;
                   }else{
                        return false;
                   }

                case 'GET':
                    if($user_to_check->hasAccess(['conference.show'])){
                        return true;
                   }else{
                        return false;
                   }

                default:
                    return false;
            }

        }else{

            return false;
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
