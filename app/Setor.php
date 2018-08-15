<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setor extends Model
{
    public $timestamps = false;
    protected $table = 'setores';
    protected $fillable = ['nome', 'descricao','ativo'];

    /**
     * busca local
     */
    public function local()
    {
        return $this->belongsTo(Local::class);
    }
    
    /**
     * busca equipamentos
     */
    public function equipamentos()
    {
        return $this->hasMany(Equipamento::class);
    }
}
