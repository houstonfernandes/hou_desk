<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CompraRequest extends FormRequest
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
                        'itens'      =>    ['required', 'min:1'],
                        'user_id'      =>    'required',
                        'fornecedor_id'      =>    'required',                        
                        'status' =>['required','numeric','min:0', 'max:3'],
//                        'pagamentos.*.valor' =>['required','numeric','min:0'],
  //                      'pagamentos.*.forma_id' =>['required','numeric','min:0'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [];
                }
            default:break;
        }
    }
}
