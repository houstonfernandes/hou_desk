<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pedido extends Model
{
    protected $table = 'pedidos';
    protected $fillable = ['user_id', 'cliente_id', 'total', 'desconto', 'data_entrega', 'status','obs'];
    
    public function items()
    {
        return $this->hasMany('App\ItemPedido');
    }
    
    /**
     * obtem o vendedor
     * */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * obtem o cliente
     * */
    public function cliente(){
        return $this->belongsTo('App\Cliente');
    }
    
    public function pagamentos()
    {
        return $this->hasMany('App\Pagamento');
    }
    

}
