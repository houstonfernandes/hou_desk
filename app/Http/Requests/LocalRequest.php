<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class LocalRequest extends FormRequest
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
                        'cnpj'      =>    ['min:14', 'max:18', 'required',
                            Rule::unique('locais')
                                ->where(function ($query) {
                                    $query->where('cnpj', $this->cnpj);
                                })
                        ],
                        'nome'      =>    ['min:3', 'max:80', 'required'],
                        'tecnico_id'      =>    ['required', 'exists:users,id']
                            
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'nome'      =>    ['min:3','max:80', 'required'],
                        'tecnico_id'      =>    ['required', 'exists:users,id']
                   ];
                }
            default:break;
        }
    }
}
