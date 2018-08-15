<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;


class CategoryRequest extends FormRequest
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
                        'name'      =>    ['min:2', 'max:80', 'required',
                            Rule::unique('categories')
                                ->where(function ($query) {
                                    $query->where('name', $this->name);
                                })
                        ],
                        'description'      =>    ['min:2', 'required']
                            
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name'      =>    ['min:2', 'max:80','required',
                            Rule::unique('categories')
                                ->where(function ($query) {
                                        $query->where([
                                            ['name','=', $this->name],
                                            ['id', '<>', $this->get('id')]
                                        ]);
                                    }
                                )],
                        'description'      =>    ['min:2', 'required']
                   ];
                }
            default:break;
        }
        
        
    }
}
