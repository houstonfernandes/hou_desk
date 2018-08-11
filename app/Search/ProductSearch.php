<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Product;

class ProductSearch
{
    public static function apply(Request $request)
    {
        $product = (new Product())->newQuery();
/*
 @refazer commit         
        if($request->data_fato_min && $request->data_fato_min!='') {//tem data min
            $data_fato_min = $request->data_fato_min;
            $documento->where('data_fato', '>=', dataGravar($data_fato_min));
        }
*/
        if($request->nome && trim($request->nome)!='') {
            $product->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->marca && trim($request->marca)!='') {
            $product->where('marca', 'like', '%' . $request->marca . '%');
        }
        
        if($request->cod_barra && trim($request->cod_barra)!='') {
            $product->where('cod_barra', 'like', '%' . $request->cod_barra . '%');
        }

        if($request->categoria && trim($request->categoria)!='') {
            $product->where('category_id', $request->categoria);
        }
        
        if($request->limit) {//limite de linhas
            $product->limit($request->limit);
        }
        
        // Get the results and return them.
        return $product;
    }
}
