<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Config;
use App\Pedido;
use App\Domains\PedidoRepository;
use Illuminate\Support\Facades\Auth;
use App\Cliente;
use App\Category;
use App\Http\Requests\PedidoRequest;


class PedidosController extends Controller
{
    private $pedidos;
    
    public function __construct(PedidoRepository $pedido){
        $this->pedidos= $pedido;
    }
    
    public function index()    
    {
        $pedidos= $this->pedidos->listaPaginada();
        return view('admin.pedido.index', compact('pedidos'));
    }
    
    /**
     * cria view para mercado
     */
    public function createMercado()
    {
        $user = Auth::user();
        $cliente = Cliente::find(1);//cliente padrão
        $statusPedidos = config('enums.statusPedidos');
        $formasPagamento = config('enums.formasPagamentos');
        $categorias = Category::all();
        
        return view('admin.pedido.create_mercado', compact('user', 'cliente', 'statusPedidos','formasPagamento', 'categorias'));
    }
    
    public function store(PedidoRequest $request)
    {
        $saida = $this->pedidos->store($request);
        return response()->json($saida, $saida['statusCode']);
    }
    
    public function consultar($id){                
        $pedido = $this->pedidos->findByID($id);
        $formasPagamento = config('enums.formasPagamentos');
        return view('admin.pedido.consultar', compact('pedido','formasPagamento'));
    }
    
}
