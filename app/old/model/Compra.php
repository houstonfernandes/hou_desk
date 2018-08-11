<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    protected $table = 'compras';
    protected $fillable = ['user_id', 'fornecedor_id', 'total', 'frete', 'imposto', 'nf','obs','status', 'data_chegada'];
    
    public function items()
    {
        return $this->hasMany('App\ItemCompra');
    }
    
    /**
     * obtem o comprador
     * */
    public function user(){
        return $this->belongsTo('App\User');
    }

    /**
     * obtem o fornecedor
     * */
    public function fornecedor(){
        return $this->belongsTo('App\Fornecedor');
    }
    
    /* @todo
    public function pagamentosCompras()
    {
        return $this->hasMany('App\PagamentoCompra');
    }
    */

}
