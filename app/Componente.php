<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Componente extends Model
{
    public $timestamps = false;
    protected $table = 'componentes';
    protected $fillable = ['nome', 'tipo_equipamento_id'];

    /**
     * busca equipamentos
     */
    public function equipamentos()
    {
        return $this->belongsToMany(Equipamento::class);
    }
}
