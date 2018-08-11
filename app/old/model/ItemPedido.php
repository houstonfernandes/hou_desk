<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemPedido extends Model
{
    public $timestamps = false;
    protected $table = 'itens_pedido';
    protected $fillable = [
        'product_id', 'pedido_id', 'preco', 'desconto', 'qtd', 
    ];
    /**
     * retorna o pedido do item
     */
    public function pedido()
    {
        return $this->belongsTo('App\Pedido');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
