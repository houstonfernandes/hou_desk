<?php

namespace App;

use Illuminate\Database\Eloquent\Model;


class Servico extends Model
{
    protected $table = 'servicos';
    protected $fillable = [
        'solicitante_id', 'executor_id', 'equipamento_id', 'tipo_servico_id', 'descricao','solucao',
        'situacao', 'data_solucao'
    ];
    protected $attributes = [
        'situacao' => 0
    ];
        
    /**
     * obtem o solicitante
     * */
    public function solicitante()
    {
        return $this->belongsTo(User::class, 'solicitante_id', 'id');
    }
    
    /**
     * obtem o técnico
     * */
    public function tecnico()
    {
        return $this->belongsTo(User::class, 'executor_id', 'id');        
    }
    
    /**
     * obtem o tipo de servico
     * */
    public function tipoServico()
    {
        return $this->belongsTo('App\TipoServico');
    }
}
