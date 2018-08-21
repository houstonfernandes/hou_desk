<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\TipoEquipamentoRepository;
use App\Http\Requests\TipoEquipamentoRequest;

class TipoEquipamentoController extends Controller
{
    private $repository;
    public function __construct(TipoEquipamentoRepository $repository){
        $this->repository= $repository;
    }
    public function index()    
    {
        $tiposEquipamento = $this->repository->listaPaginada();
        return view('admin.tipos_equipamento.index', compact('tiposEquipamento'));
    }
    
    public function create()
    {
        return view('admin.tipos_equipamento.create');
    }
    
    public function store(TipoEquipamentoRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.tipos_equipamento.index');
    }
    
    public function edit($id){
        $tipoEquipamento = $this->repository->findByID($id);
        return view('admin.tipos_equipamento.edit', compact('tipoEquipamento'));
    }
    
    public function update($id, TipoEquipamentoRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.tipos_equipamento.index');
    }
    
    public function delete($id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.tipos_equipamento.index');
    }
}
