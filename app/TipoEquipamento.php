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
        return $this->hasMany('App\Equipamento');
    }
    
    /**
     * busca os componentes do tipo
     */
    public function componentes()
    {
        return $this->hasMany('App\Componente');
    }
    
    public function scopeAtivo($query){
        return $query->where('ativo', '=', 1);
    }
    

}
