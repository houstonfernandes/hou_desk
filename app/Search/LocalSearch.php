<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Local;

class LocalSearch
{
    public static function apply(Request $request)
    {
        $obj = (new Local())->newQuery();
        if($request->nome && trim($request->nome)!='') {
            $obj->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->nome_fantasia && trim($request->nome_fantasia)!='') {
            $obj->where('nome_fantasia', 'like', '%' . $request->nome_fantasia . '%');
        }
        
        if($request->endereco && trim($request->endereco)!='') {
            $obj->where('endereco', 'like', '%' . $request->endereco . '%');
        }
        

        if($request->cidade && trim($request->cidade)!='') {
            $obj->where('cidade', 'like', '%' . $request->cidade . '%');
        }
        
        if($request->email && trim($request->email)!='') {
            $obj->where('email', 'like', '%' . $request->email . '%');
        }
                
        if($request->ponto_ref && trim($request->ponto_ref)!='') {
            $obj->where('ponto_ref', 'like', '%' . $request->ponto_ref . '%');
        }
        
        if($request->limit) {//limite de linhas
            $obj->limit($request->limit);
        }
        
        // Get the results and return them.
        return $obj;
    }
}
