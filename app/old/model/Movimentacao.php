<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Movimentacao extends Model
{
    protected $table = 'movimentacao';
    protected $fillable = [
        'product_id', 'operacao','operacao_id', 'qtd', 'qtd_anterior'
    ];
    
    /*
     *Retorna o produto movimentado 
     */
    public function product()
    {
        return $this->belongsTo('App\Product');
    }
}
