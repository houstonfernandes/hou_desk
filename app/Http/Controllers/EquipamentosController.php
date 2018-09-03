<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Domains\EquipamentoRepository;

use App\Http\Requests\EquipamentoRequest;
use App\Local;
use App\TipoEquipamento;

class EquipamentosController extends Controller
{
    private $repository;
    public function __construct(EquipamentoRepository $repository){
        $this->repository= $repository;
    }
    
    public function index($id)    
    {
        $local = Local::find($id);
        $equipamentos = $this->repository->listaPaginadaLocal($id);        
        return view('admin.equipamentos.index', compact('local', 'equipamentos'));
    }
    
    public function create($id)
    {
        $local = Local::find($id);
        $tiposEquipamentos = TipoEquipamento::ativo()->get();
        return view('admin.equipamentos.create', compact('local', 'tiposEquipamentos'));
    }
    
    public function store(EquipamentoRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.equipamentos.index', $request->local_id);
    }
    
    public function edit($id){
        $tiposEquipamentos = TipoEquipamento::ativo()->get();
        $equipamento = $this->repository->findByID($id);
        $local = $equipamento->setor->local;
        return view('admin.equipamentos.edit', compact('equipamento', 'tiposEquipamentos', 'local'));
    }
    
    public function update($id, EquipamentoRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.equipamentos.index', $request->local_id);
    }
    
    public function delete($id)
    {
        $equipamento = $this->repository->findByID($id);
        $local = $equipamento->setor->local;        
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.equipamentos.index', $local->id);
    } 
    /**
     * procura fornecedor por diversos campos
     * @param request [nome, ]
     * @return array json
     */
    public function search(Request $request){
        $saida = $this->repository->search($request);
        return response()->json($saida, $saida['statusCode']);
    }
    
}
