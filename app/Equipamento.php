<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipamento extends Model
{
    protected $table = 'equipamentos';
    protected $fillable = [
        'nome', 'marca', 'descricao', 'num_patrimonio', 'num_etiqueta', 'data_aquisicao',  
        'custo', 'origem', 'situacao', 'categoria_id' 
    ];
    
    protected $attributes = [//valores default
    ];

    /**
     * busca a categoria do produto
     */
    public function categoria(){
        return $this->belongsTo('App\Categoria');
    }

    /**
     * busca as imagens do equipamento
     */
    public function imagens(){
        return $this->hasMany('App\EquipamentoImagem');
    }

    /**
     * busca as tags do equipamento n:m
     */
    public function tags(){
        return $this->belongsToMany('App\Tag');
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
     * busca produtos por categorias
     * @param $query
     * @param $id - id da category
     * @return mixed - collection de produtos
     */
    public function scopeOfCategoria($query, $id){
        return $query->where('category_id', '=', $id);
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
                $img->id . '.' . $img->extension,
                $img->id . '_thumbnail.' . $img->extension
            ];
        return null;
    }    
}