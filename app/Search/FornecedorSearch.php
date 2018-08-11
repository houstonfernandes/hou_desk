<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Product;
use App\Cliente;
use App\Fornecedor;

class FornecedorSearch
{
    public static function apply(Request $request)
    {
        $fornecedor = (new Fornecedor())->newQuery();
        if($request->nome && trim($request->nome)!='') {
            $fornecedor->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->nome_fantasia && trim($request->nome_fantasia)!='') {
            $fornecedor->where('nome_fantasia', 'like', '%' . $request->nome_fantasia . '%');
        }
        
        if($request->endereco && trim($request->endereco)!='') {
            $fornecedor->where('endereco', 'like', '%' . $request->endereco . '%');
        }
        

        if($request->cidade && trim($request->cidade)!='') {
            $fornecedor->where('cidade', 'like', '%' . $request->cidade . '%');
        }
        
        if($request->email && trim($request->email)!='') {
            $fornecedor->where('email', 'like', '%' . $request->email . '%');
        }
        
        if($request->tipo_fornecedor && trim($request->tipo_fornecedor)!='') {
            $fornecedor->where('tipo_fornecedor', $request->tipo_fornecedor);
        }
        
        if($request->limit) {//limite de linhas
            $fornecedor->limit($request->limit);
        }
        
        // Get the results and return them.
        return $fornecedor;
    }
}
