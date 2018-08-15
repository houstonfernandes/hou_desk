<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Setor;

class SetorSearch
{
    public static function apply(Request $request)
    {
        $obj = (new Setor())->newQuery();
        if($request->nome && trim($request->nome)!='') {
            $obj->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->descricao && trim($request->descricao)!='') {
            $obj->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        
        if($request->limit) {//limite de linhas
            $obj->limit($request->limit);
        }
        
        // Get the results and return them.
        return $obj;
    }
}
