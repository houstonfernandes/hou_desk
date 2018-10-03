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
        $tiposEquipamento = TipoEquipamento::all(['id', 'nome']);
        $locais = Local::all(['id','nome']);
                
        $saida = $repository->relatorioDescritivo($request);
        $equipamentos = $saida['equipamentos'];
        return view('relatorios.equipamentos_descritivo', compact('equipamentos', 'tiposEquipamento','locais'));
    }    
}
