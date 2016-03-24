<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\Models\User as User;

class UserRequest extends Request
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
                        return true;
                  
                  
                case 'PUT':
                //TODO check if user to update is current user
                    if($user_to_check->hasAccess(['user.update'])){
                        return true;
                   }else{
                        return false;
                   }

                case 'DESTROY':
                        return false;
                   

                case 'GET':
                //TODO: user to get == current user check
                        return true;
                   

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
