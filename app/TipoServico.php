<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    protected $table = 'tipos_servico';
    public $timestamps = false;
    protected $fillable = ['nome'];
    /**
     * busca serviços desse tipo
     */
    public function servicos()
    {
        return $this->belongsToMany('App\Servico');
    }
    
    public function scopeOfTipoServico($query, $id){
        return $query->where('id', '=', $id);
    }
}
