<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoServico extends Model
{
    protected $table = 'tipos_servico';
    public $timestamps = false;
    protected $fillable = ['nome','duracao','duracao_unidade'];
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
    
    /**
     * retorna a duracao do tipo de serviço em minutos, usada no timericone moment.js
     * @return int minutos
     */
    public function duracaoMinutos(){
        $tempo = $this->duracao;
        $unidade = strtolower($this->duracao_unidade);
        switch ($unidade){
            case 'd':
                $tempo = $tempo * 24 * 60;
                break;
            case 'h':
                $tempo = $tempo * 60;
                break;
        }
        return (int)$tempo;        
    }
    
}
