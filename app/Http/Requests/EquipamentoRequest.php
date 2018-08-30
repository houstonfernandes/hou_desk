<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class EquipamentoRequest extends FormRequest
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
                        'nome'      =>    ['min:2', 'max:80', 'required'],
                        'data_aquisicao' => ['date_format:"d/m/Y"'],
                        'tipo_equipamento_id'      =>    ['required'],
                        'setor_id'      =>    ['required'],
                    ];
                        
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'nome'      =>    ['min:2', 'max:80', 'required'],
                        'data_aquisicao' => ['date_format:"d/m/Y"'],
                        'tipo_equipamento_id'      =>    ['required'],
                        'setor_id'      =>    ['required'],
                   ];
                }
            default:break;
        }
    }
}
