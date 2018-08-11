<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
/*        return [
            'name' => 'required|max:255',
            'email' => 'required|email|max:255|unique:users',
            //'email' => 'required|email|max:255|unique:users' . $user->id,
            'password' => 'required|min:6|confirmed'.$user->id,
            //'password' => 'requiredunique:users,email_address,$user->id,id,account_id,1'
        ];*/
//dd($this->get('id'));
//dd($this->segment(2));
//dd($this->id);
        switch($this->method())
        {
            case 'GET':
            case 'DELETE':
            {
                return [];
            }
            case 'POST':
            {
                return [
                    'email'      => 'required|email|unique:users,email',
                    'password'   => 'required|min:6|confirmed',
                ];
            }
            case 'PUT':
            case 'PATCH':
            {
                return [
                    'email'      => 'required|email|unique:users,email,' . $this->get('id'),
                    //'password'   => "required," . $this->get('id')///,$this->segment(2),
                ];
            }
            default:break;
        }
    }
}
