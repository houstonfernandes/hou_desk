<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Product;
use App\Cliente;

class ClienteSearch
{
    public static function apply(Request $request)
    {
        $cliente = (new Cliente())->newQuery();
        if($request->nome && trim($request->nome)!='') {
            $cliente->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->cod_barra && trim($request->nome_fantasia)!='') {
            $cliente->where('nome_fantasia', 'like', '%' . $request->nome_fantasia . '%');
        }
        
        if($request->marca && trim($request->endereco)!='') {
            $cliente->where('endereco', 'like', '%' . $request->endereco . '%');
        }
        

        if($request->cod_barra && trim($request->cidade)!='') {
            $cliente->where('cidade', 'like', '%' . $request->cidade . '%');
        }
        
        if($request->cod_barra && trim($request->email)!='') {
            $cliente->where('email', 'like', '%' . $request->email . '%');
        }
        
        if($request->categoria && trim($request->tipo_cliente)!='') {
            $cliente->where('tipo_cliente', $request->tipo_cliente);
        }
        
        if($request->limit) {//limite de linhas
            $cliente->limit($request->limit);
        }
        
        // Get the results and return them.
        return $cliente;
    }
}
