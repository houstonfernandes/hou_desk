<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Pagamento extends Model
{
    protected $table = 'pagamentos';
    protected $fillable = ['pedido_id', 'tipo', 'valor'];
    
    public function pedido()
    {
        return $this->belongsTo('App\Pedido');
    }
}
