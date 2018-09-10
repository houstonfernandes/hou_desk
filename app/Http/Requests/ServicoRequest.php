<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


class ServicoRequest extends FormRequest
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
                        'equipamento_id' => ['required'],
                        'tipo_servico_id' => ['required'],
                        'descricao' => ['required', 'min:3'],
                    ];                        
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'equipamento_id' => ['required'],
                        'tipo_servico_id' => ['required'],
                        'descricao' => ['required', 'min:3'],
                    ];
                }
            default:break;
        }
    }
}
