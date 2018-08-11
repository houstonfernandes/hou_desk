<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    public $timestamps = false;
    protected $fillable = ['nome'];
    /**
     * busca os produtos da tag
     */
    public function servicos()
    {
        return $this->belongsToMany('App\Servico');
    }

    public function scopeOfTipoServico($query, $id){
        return $query->where('id', '=', $id);
    }
}
