<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $table = 'equipamentos';
    protected $fillable = [
        'nome', 'marca', 'descricao', 'num_patrimonio', 'num_etiqueta', 'data_aquisicao',  
        'custo', 'origem', 'situacao', 'tipo_equipamento_id', 'setor_id' 
    ];
    
    protected $attributes = [//valores default
    ];

    /**
     * busca a setor
     */
    public function setor(){
        return $this->belongsTo('App\Setor');
    }

    /**
     * busca o tipo
     */
    public function tipoEquipamento(){
        return $this->belongsTo('App\TipoEquipamento');
    }
    
    /**
     * busca as imagens do equipamento
     */
    public function imagens(){
        return $this->hasMany('App\EquipamentoImagem');
    }

    /**
     * busca os servicos do equipamento
     */
    public function servicos(){
        return $this->hasMany('App\Servico');
    }
    
    /**
     * busca os componentes do equipamento n:m
     */
    public function componentes(){
        return $this->belongsToMany('App\ComponenteEquipamento');
    }

    /**
     * lista ativos
     * @param $query
     * @return mixed
     */
    public function scopeAtivo($query)
    {
        return $query->where('situacao', '=', '1');
            //->limit(12);
    }
    
    /**
     * busca equipamentos por tipo
     * @param $query
     * @param $id - id do tipo
     * @return mixed - collection de equipamentos
     */
    public function scopeOfTipoEquipamento($query, $id){
        return $query->where('tipo_equipamento_id', '=', $id);
    }

    /**
     * retorna o nome da primeira imagem
     * @return string nome do arquivo
    */
    public function nomePrimeiraImagem()
    {
        $img = $this->images()->first();
        if(count($img))
            return [
                $img->id . '.' . $img->extensao,
                $img->id . '_thumbnail.' . $img->extensao
            ];
        return null;
    }    
}