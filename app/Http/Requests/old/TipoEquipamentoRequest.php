<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class TipoEquipamentoRequest extends FormRequest
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
      
        
        switch($this->method())
        {
            case 'GET':
                {                    
                    return [];
                }
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'nome'      =>    ['min:3', 'max:80', 'required']
                            
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'nome'      =>    ['min:3','max:80', 'required']
                   ];
                }
            default:break;
        }
        
        
    }
}