<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Fornecedor;
use App\Http\Requests\FornecedorRequest;
use App\Domains\FornecedorRepository;

class FornecedoresController extends Controller
{
    private $repository;
    public function __construct(FornecedorRepository $repository){
        $this->repository= $repository;
    }
    public function index()    
    {
        $fornecedores = $this->repository->listaPaginada();
        return view('admin.fornecedor.index', compact('fornecedores'));
    }
    
    public function create()
    {
        $ufBrasil = ufBrasil();
        return view('admin.fornecedor.create', compact('ufBrasil'));
    }
    
    public function store(FornecedorRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.fornecedores.index');
    }
    
    public function edit($id){
        $ufBrasil = ufBrasil();
        $fornecedor = $this->repository->findByID($id);
        return view('admin.fornecedor.edit', compact('fornecedor', 'ufBrasil'));
    }
    
    public function update($id, FornecedorRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.fornecedores.index');
    }
    
    public function delete( $id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.fornecedores.index');
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
