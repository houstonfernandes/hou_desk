<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class AtenderServicoRequest extends FormRequest
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
                        'solucao' => ['min:5', 'nullable'],
                        'servico_id' => ['required'],
                        'situacao' =>['required', 'min:3', 'max:5']
                    ];                        
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'solucao' => ['min:5', 'nullable'],
                        'servico_id' => ['required'],
                        'situacao' =>['required', 'min:3', 'max:5', 'integer']
                    ];
                }
            default:break;
        }
    }
}
