<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Domains\LocalRepository;
use App\Http\Requests\LocalRequest;
use App\User;

class LocaisController extends Controller
{
    private $repository;
    public function __construct(LocalRepository $repository){
        $this->repository= $repository;
    }
    public function index()    
    {
        $locais = $this->repository->listaPaginada();
        return view('admin.locais.index', compact('locais'));
    }
    
    public function create()
    {
        $ufBrasil = ufBrasil();
        $tecnicos = User::tecnicos();
        return view('admin.locais.create', compact('ufBrasil','tecnicos'));
    }
    
    public function store(LocalRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.locais.index');
    }
    
    public function edit($id){
        $ufBrasil = ufBrasil();
        $tecnicos = User::tecnicos();
        $local = $this->repository->findByID($id);
        return view('admin.locais.edit', compact('local', 'ufBrasil', 'tecnicos'));
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
    
    /**
     * lista por setores local
     * @param integer $id
     * @return array json
     */
    public function listarSetores($id)
    {
        $saida = $this->repository->listarSetores($id);
        return response()->json($saida, $saida['statusCode']);
    }
    
}
