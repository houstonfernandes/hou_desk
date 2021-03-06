<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Equipamento;

class EquipamentoSearch
{
    public static function apply(Request $request)
    {
        $obj = (new Equipamento())->newQuery();
        if($request->nome && trim($request->nome)!='') {
            $obj->where('nome', 'like', '%' . $request->nome . '%');
        }

        if($request->marca && trim($request->marca)!='') {
            $obj->where('marca', 'like', '%' . $request->marca . '%');
        }
        
        if($request->descricao && trim($request->descricao)!='') {
            $obj->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        
        if($request->num_patrimonio && trim($request->num_patrimonio)!='') {
            $obj->where('num_patrimonio', 'like', '%' . $request->num_patrimonio . '%');
        }
        
        if($request->origem && trim($request->origem)!='') {
            $obj->where('origem', 'like', '%' . $request->origem . '%');
        }
                
        if($request->setor_id && trim($request->setor_id)!='') {
            $obj->where('setor_id', '=', $request->setor_id);
        }

        if($request->tipo_equipamento_id && trim($request->tipo_equipamento_id)!='') {
            $obj->where('tipo_equipamento_id', '=', $request->tipo_equipamento_id);
        }
        
        if($request->situacao != null) {
            $obj->where('situacao', '=', $request->situacao);
        }
        
        if($request->limit) {//limite de linhas
            $obj->limit($request->limit);
        }
        
        // Get the results and return them.
        return $obj;
    }
}
