<?php

namespace App\Http\Controllers;

use App\Http\Requests\TipoServicoRequest;
use App\Domains\TipoServicoRepository;

class TipoServicoController extends Controller
{
    private $repository;
    public function __construct(TipoServicoRepository $repository)
    {
        $this->repository= $repository;
    }
    
    public function index()    
    {
        $tiposServico = $this->repository->listaPaginada();
//dd($tiposServico);        
        return view('admin.tipos_servico.index', compact('tiposServico'));
    }
    
    public function create()
    {
        return view('admin.tipos_servico.create');
    }
    
    public function store(TipoServicoRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.tipos_servico.index');
    }
    
    public function edit($id){
        $tipoServico = $this->repository->findByID($id);
        return view('admin.tipos_servico.edit', compact('tipoServico'));
    }
    
    public function update($id, TipoServicoRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.tipos_servico.index');
    }
    
    public function delete($id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.tipos_servico.index');
    }
}
