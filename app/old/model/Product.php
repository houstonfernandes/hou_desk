<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $fillable = [
        'cod_barra', 'nome', 'marca', 'descricao', 'qtd', 'qtd_min', 'qtd_max', 'unidade', 
        'preco', 'preco_promocao', 'promocao', 'destaque', 'ativo', 'category_id' 
    ];
    
    protected $attributes = [//valores default
        'unidade' =>'un.',
    ];

    /**
     * busca a categoria do produto
     */
    public function category(){
        return $this->belongsTo('App\Category');
    }

    /**
     * busca as imagens do produto
     */
    public function images(){
        return $this->hasMany('App\ProductImage');
    }

    /**
     * busca as tags do produto n:m
     */
    public function tags(){
        return $this->belongsToMany('App\Tag');
    }

    /**
     * busca as itempedidos do produto n:m @todo 
     */
    public function itemPedidos(){
        return $this->hasMany('App\ItemPedido');
//        return $this->belongsToMany('App\ItemPedido','itens_pedido','product_id','pedido_id');    //resolver problema com pivot table    
    }
    
    //@todo devolucoes, compras, ajustes n:m ***********
    
     
    /** lista produtos em destaque
     * @see Product::featured()->get
     *
     */
    public function scopePromocao($query)
    {
        return $query->where('promocao', '=', true);//->limit(6);
    }

    /**
     * lista produtos recomendados
     * @param $query
     * @return mixed
     */
    public function scopeAtivo($query)
    {
        return $query->where('ativo', '=', '1');
            //->limit(12);
    }
    
    /**
     * busca produtos por categorias
     * @param $query
     * @param $id - id da category
     * @return mixed - collection de produtos
     */
    public function scopeOfCategory($query, $id){
        return $query->where('category_id', '=', $id);
    }

    /**
     * retorna o nome da primeira imagem
     * @return string nome do arquivo
    */
    public function firstImageName()
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