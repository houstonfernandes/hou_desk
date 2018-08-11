<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cliente extends Model
{
    protected $table = 'clientes';
    protected $fillable = [
        'nome', 'nome_fantasia', 'cpf', 'endereco', 'numero', 'bairro', 'cidade', 
        'uf','ponto_ref', 'cep', 'complemento', 'tel', 'cel', 'email', 'obs', 'tipo_cliente',
    ];
    
    protected $attributes = [//valores default
    ];
    
    /**
     * busca pedidos do cliente
     */
    public function pedidos(){
        return $this->hasMany('App\Pedido');
    }
}
