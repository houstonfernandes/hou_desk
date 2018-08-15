<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\FornecedorRequest;
use App\Domains\LocalRepository;
use App\Http\Requests\LocalRequest;

class LocaisController extends Controller
{
    private $repository;
    public function __construct(LocalRepository $repository){
        $this->repository= $repository;
    }
    public function index()    
    {
        $locais = $this->repository->listaPaginada();
        return view('admin.local.index', compact('locais'));
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
