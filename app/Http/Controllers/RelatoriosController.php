<?php

namespace App\Http\Controllers;

use App\Local;
use App\TipoEquipamento;
use App\Domains\EquipamentoRepository;
use Illuminate\Http\Request;

class RelatoriosController extends Controller
{
    public function equipamentosDescritivo(Request $request, EquipamentoRepository $repository)
    {
        $tipo_equipamento_id = 0;
        $local_id = 0;
        
        $tiposEquipamento = TipoEquipamento::all(['id', 'nome']);
        $locais = Local::all(['id','nome']);
                        
        $saida = $repository->relatorioDescritivo($request);
        $equipamentos = $saida['equipamentos'];
        
        if(session()->has('rel_tipo_equipamento_id')){
            $tipo_equipamento_id = session('rel_tipo_equipamento_id');
        }
        
        if(session()->has('rel_local_id')){
            $local_id = session('rel_local_id');
        }
//dd($local_id);
//dd(str_plural('palavra'));
        return view('relatorios.equipamentos_descritivo', compact('equipamentos', 'tiposEquipamento','locais', 'tipo_equipamento_id','local_id'));
    }    
}
