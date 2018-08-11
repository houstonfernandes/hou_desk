<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class EquipamentoImagem extends Model
{
    protected $table = 'equipamento_imagens';    
    public $timestamps = false;
    protected $fillable = [
        'product_id',
        'extension'
    ];

    public function equipamento(){
        return $this->belongsTo('App\Equipamento');
    }
}
