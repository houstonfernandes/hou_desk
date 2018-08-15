<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Category;

class CategorySearch
{
    public static function apply(Request $request)
    {
        $category = (new Category())->newQuery();
        if($request->nome && trim($request->name)!='') {
            $fornecedor->where('name', 'like', '%' . $request->name . '%');
        }

        if($request->cod_barra && trim($request->description)!='') {
            $fornecedor->where('description', 'like', '%' . $request->description . '%');
        }

        return $category;
    }
}
