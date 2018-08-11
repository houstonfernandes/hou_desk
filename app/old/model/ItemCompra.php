<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ItemCompra extends Model
{
    public $timestamps = false;
    protected $table = 'itens_compra';
    protected $fillable = [
        'product_id', 'compra_id', 'preco', 'qtd','qtd_entregue', 'desconto', 'obs'
    ];
    
    /**
     * retorna o pedido de compra do item
     */
    public function compra()
    {
        return $this->belongsTo('App\Compra');
    }
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
