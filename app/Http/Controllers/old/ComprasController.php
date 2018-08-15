<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Pedido;
use App\Domains\PedidoRepository;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Category;
use App\Http\Requests\PedidoRequest;
use App\Domains\CompraRepository;
use App\Domains\FornecedorRepository;
use App\Fornecedor;
use App\Http\Requests\CompraRequest;


class ComprasController extends Controller
{
    private $repository;
    
    public function __construct(CompraRepository $repository){
        $this->repository = $repository;
    }
    
    public function index()    
    {
        $compras = $this->repository->listaPaginada();
        $statusCompras = config('enums.statusCompras');
        return view('admin.compra.index', compact('compras', 'statusCompras'));
    }
    
    /**
     * cria view para mercado
     */
    public function create()
    {
        $user = Auth::user();
        $fornecedores = Fornecedor::all('id','nome');
        $statusCompras = config('enums.statusCompras');
        //$formasPagamento = config('enums.formasPagamentos');
        $categorias = Category::all();        
        //dd($categorias);
        return view('admin.compra.create', compact('user', 'fornecedores', 'statusCompras', 'categorias'));
    }
    
    public function store(CompraRequest $request)
    {
        $saida = $this->repository->store($request);
        return response()->json($saida, $saida['statusCode']);
    }
    
    public function consultar($id){                
        $pedido = $this->repository->findByID($id);
        $statusCompras = config('enums.statusCompras');        
//        $formasPagamento = config('enums.formasPagamentos');
        return view('admin.compra.consultar', compact('pedido','statusCompras'));
    }
    
    public function edit($id){
        $compra = $this->repository->findByID($id);
        $itens = $compra->items()->with('product.images')->get();
        foreach ($itens as $item){
            $item->qtd_entregue = $item->qtd;//iniciar como se entregure tudo. se preciso editar  
        }
        //$urlImagem = storage_path('product_images');//Storage::disk('product_images')->url();
        //dd($urlImagem);
        //dd($items[0]->product);
        //$statusCompras = config('enums.statusCompras');
        //        $formasPagamento = config('enums.formasPagamentos');
        return view('admin.compra.edit', compact('compra', 'itens'));
    }
    
    public function edit_vue($id){
        $compra = $this->repository->findByID($id);
        $itens = $compra->items()->with('product.images')->get();
        foreach ($itens as $item){
            $item->qtd_entregue = $item->qtd;//iniciar como se entregure tudo. se preciso editar
        }
        return view('admin.compra.edit_vue', compact('compra', 'itens'));
    }
    
    public function update($id, CompraRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        return response()->json($saida, $saida['statusCode']);
    }
}
