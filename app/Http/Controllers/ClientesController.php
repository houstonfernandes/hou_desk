<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cliente;
use App\Http\Requests\ClienteRequest;
use App\Domains\ClienteRepository;

class ClientesController extends Controller
{
    private $repository;
    public function __construct(ClienteRepository $repository){
        $this->repository = $repository;
    }
    public function index()    
    {
        $clientes = $this->repository->listaPaginada();
        return view('admin.cliente.index', compact('clientes'));
    }
    
    public function create()
    {
        $ufBrasil = ufBrasil();
        return view('admin.cliente.create', compact('ufBrasil'));
    }
    
    public function store(ClienteRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.clientes.index');
    }
    
    public function edit($id){
        $ufBrasil = ufBrasil();
        $cliente = $this->repository->findByID($id);
        return view('admin.cliente.edit', compact('cliente', 'ufBrasil'));
    }
    
    public function update($id, ClienteRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.clientes.index');
    }
    
    public function delete( $id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.clientes.index');
    } 
}
