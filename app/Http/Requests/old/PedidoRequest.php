<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PedidoRequest extends FormRequest
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
                        'cliente_id'      =>    'required',                        
                        'status' =>['required','numeric','min:0', 'max:3'],
                        'pagamentos.*.valor' =>['required','numeric','min:0'],
                        'pagamentos.*.forma_id' =>['required','numeric','min:0'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'cod_barra'      =>    ['min:2', 'max:13',
                            Rule::unique('products')
                            ->where(function ($query) {
                                $query->where([
                                    ['cod_barra', $this->cod_barra],
                                    ['id', '<>', $this->get('id')]
                                ]);
                            })
                            ],
                        'nome' =>    ['min:2', 'max:80','required',
                            Rule::unique('products')
                                ->where(function ($query) {
                                        $query->where([
                                            ['nome','=', $this->nome],
                                            ['id', '<>', $this->get('id')]
                                        ]);
                                    }
                                )],
                        'descricao'      =>    ['max:280'],
                        'preco' =>['required','numeric','min:0'],
                        'preco_promocao' =>['numeric','nullable', 'max:'. $this->get('preco')],
                        'unidade' =>['required']
                   ];
                }
            default:break;
        }
        
        
    }
    /*
    protected function getValidatorInstance(){
        $validator = parent::getValidatorInstance();
        
        $validator->sometimes('preco_promocao', 'required', function($input)//se tiver promocao preco de promocao e requerido
        {
            return $input->promocao;
        });
        
        return $validator;
    }*/
    
    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
     */
    public function withValidator($validator)//se tiver promocao preco de promocao e requerido (SEGUNDA FORMA)
    {
        $validator->sometimes('preco_promocao', 'required', function($input)//se tiver promocao preco de promocao e requerido
        {
            return $input->promocao;
        });
    }
}
