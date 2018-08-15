<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\SetorRepository;
use App\Http\Requests\LocalRequest;
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
    
    public function create()
    {
        $ufBrasil = ufBrasil();
        return view('admin.local.create', compact('ufBrasil'));
    }
    
    public function store(LocalRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.locais.index');
    }
    
    public function edit($id){
        $ufBrasil = ufBrasil();
        $local = $this->repository->findByID($id);
        return view('admin.local.edit', compact('local', 'ufBrasil'));
    }
    
    public function update($id, LocalRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.locais.index');
    }
    
    public function delete( $id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.locais.index');
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
