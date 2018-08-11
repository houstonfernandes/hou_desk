<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Fornecedor extends Model
{
    protected $table = 'fornecedores';
    protected $fillable = [
        'nome', 'nome_fantasia', 'cpf', 'endereco', 'numero', 'bairro', 'cidade', 
        'uf','ponto_ref', 'cep', 'complemento', 'tel', 'cel', 'email', 'obs', 'tipo_fornecedor',
    ];
    
    protected $attributes = [//valores default
    ];

    
    /**
     * busca compras do fornecedor
     */
    /*
    public function compras(){
        return $this->hasMany('App\Compra');
    }
    */
}
