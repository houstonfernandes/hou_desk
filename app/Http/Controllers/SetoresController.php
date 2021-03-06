<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\SetorRepository;
use App\Http\Requests\SetorRequest;
use App\Local;

class SetoresController extends Controller
{
    private $repository;
    public function __construct(SetorRepository $repository){
        $this->repository= $repository;
    }
    public function index($id)    
    {
        $local = Local::find($id);
        $setores = $this->repository->listaPaginadaLocal($id);        
        return view('admin.setores.index', compact('local', 'setores'));
    }
    
    public function create($id)
    {
        $local = Local::find($id);        
        return view('admin.setores.create', compact('local'));
    }
    
    public function store(SetorRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.setores.index', $request->local_id);
    }
    
    public function edit($id){        
        $setor = $this->repository->findByID($id);
        $local = $setor->local;
        return view('admin.setores.edit', compact('setor', 'local'));
    }
    
    public function update($id, SetorRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.setores.index', $request->local_id);
    }
    
    public function delete($id, $local_id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.setores.index', $local_id);
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
