<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


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
                        'data_aquisicao' => ['nullable','date_format:"d/m/Y"', 'after_or_equal:' . (new \DateTime('01/01/1990'))->format("d/m/Y"), 'before_or_equal:' . (new \DateTime())->format("d/m/Y")],
                        'tipo_equipamento_id'      =>    ['required'],
                        'setor_id'      =>    ['required'],
                    ];
                        
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'nome' => ['min:2', 'max:80', 'required'],
                        'data_aquisicao' => ['nullable','date_format:"d/m/Y"', 'after_or_equal:' . (new \DateTime('01/01/1990'))->format("d/m/Y"), 'before_or_equal:' . (new \DateTime())->format("d/m/Y")],                        
                        'tipo_equipamento_id' => ['required'],
                        'setor_id' => ['required'],
                   ];
                }
            default:break;
        }
    }
}
