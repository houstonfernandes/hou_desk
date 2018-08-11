<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoEquipamento extends Model
{
    public $timestamps = false;
    protected $table = 'tipos_equipamento';
    protected $fillable = ['nome', 'descricao','ativo'];
    
    /**
     * busca os equipamentos do tipo
     */
    public function equipamentos()
    {
        return $this->belongsToMany('App\Equipamento');
    }

    public function scopeOfTipoEquipamento($query, $id){
        return $query->where('id', '=', $id);
    }


}
