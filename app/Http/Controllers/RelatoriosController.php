<?php

namespace App\Http\Controllers;

use App\Local;
use App\TipoEquipamento;
use App\User;
use App\Domains\EquipamentoRepository;
use Illuminate\Http\Request;
use App\Domains\ServicoRepository;
use App\TipoServico;

class RelatoriosController extends Controller
{
    public function equipamentosDescritivo(Request $request, EquipamentoRepository $repository)
    {
        $tipo_equipamento_id = 0;
        $local_id = 0;
        $setor_id = 0;
        $situacao = '';
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
        if(session()->has('rel_setor_id')){
            $setor_id = session('rel_setor_id');
        }
        
        
        if(session()->has('rel_situacao')){
            $situacao = session('rel_situacao');
        }
//        dd($local);
        
//dd($local_id);
//dd(str_plural('palavra'));
        return view('relatorios.equipamentos_descritivo', compact('equipamentos', 'tiposEquipamento','locais', 'tipo_equipamento_id','local_id', 'setor_id', 'situacao'));
    }
    
    public function equipamentosQuantitativo(Request $request, EquipamentoRepository $repository)
    {
        $tipo_equipamento_id = 0;
        $local_id = 0;
        $situacao = '';
        $tiposEquipamento = TipoEquipamento::all(['id', 'nome']);
        $locais = Local::all(['id','nome']);
        
        $saida = $repository->relatorioQuantitativo($request);
//dd($saida);
        $equipamentos = $saida['equipamentos'];
        
        if(session()->has('rel_tipo_equipamento_id')){
            $tipo_equipamento_id = session('rel_tipo_equipamento_id');
        }
        
        if(session()->has('rel_local_id')){
            $local_id = session('rel_local_id');
        }
        
        if(session()->has('rel_situacao')){
            $situacao = session('rel_situacao');
        }
        
        return view('relatorios.equipamentos_quantitativo', compact('equipamentos', 'tiposEquipamento','locais', 'tipo_equipamento_id','local_id', 'situacao'));
    }
    
    public function servicosQuantitativo(Request $request, ServicoRepository $repository)
    {
        $tipo_equipamento_id = '';
        $tipo_servico_id = '';
        $local_id = 0;
        $situacao = '';
        $tiposEquipamento = TipoEquipamento::all(['id', 'nome']);
        $tiposServico = TipoServico::all(['id', 'nome']);
        $locais = Local::all(['id','nome']);
        $tecnicos = User::tecnicos();
        $tecnico_id = 0;
//dd($tecnicos);        
        $saida = $repository->relatorioQuantitativo($request);
        //dd($saida);
        $servicos = $saida['servicos'];
        
        if(session()->has('rel_tipo_equipamento_id')){
            $tipo_equipamento_id = session('rel_tipo_equipamento_id');
        }
        if(session()->has('rel_tipo_servico_id')){
            $tipo_servico_id = session('rel_tipo_servico_id');
        }        
        if(session()->has('rel_local_id')){
            $local_id = session('rel_local_id');
        }        
        if(session()->has('rel_tecnico_id')){
            $tecnico_id = session('rel_tecnico_id');
        }
        if(session()->has('rel_situacao')){
            $situacao = session('rel_situacao');
        }
        
        return view('relatorios.servicos_quantitativo', compact('servicos', 'tiposEquipamento', 'tiposServico', 'locais', 'tipo_equipamento_id', 'tipo_servico_id', 'local_id', 'situacao', 'tecnicos', 'tecnico_id'));
    }
    
    
}
