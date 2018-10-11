<?php
namespace App\Search;

use Illuminate\Http\Request;
use App\Servico;

class ServicoSearch
{
    public static function apply(Request $request)
    {
        $obj = (new Servico())->newQuery();
        
        if($request->solicitante_id && trim($request->solicitante_id)!='') {
            $obj->where('solicitante_id', '=', $request->solicitante_id);
        }

        if($request->executor_id && trim($request->executor_id)!='') {
            $obj->where('executor_id', '=', $request->executor_id);
        }
        
        if($request->equipamento_id && trim($request->equipamento_id)!='') {
            $obj->where('equipamento_id', '=', $request->equipamento_id);
        }
        
        if($request->tipo_servico_id && trim($request->tipo_servico_id)!='') {
            $obj->where('tipo_servico_id', '=', $request->tipo_servico_id);
        }
        
        if($request->descricao && trim($request->descricao)!='') {
            $obj->where('descricao', 'like', '%' . $request->descricao . '%');
        }
        
        if($request->solucao && trim($request->solucao)!='') {
            $obj->where('solucao', 'like', '%' . $request->solucao . '%');
        }
        
        if($request->num_patrimonio && trim($request->num_patrimonio)!='') {
            $obj->where('num_patrimonio', 'like', '%' . $request->num_patrimonio . '%');
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
