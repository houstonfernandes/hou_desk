<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PedidoCriado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Movimentacao;

class RegistrarMovimentacaoVenda
{
    private $operacao = 1; //1- venda
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(PedidoCriado $event)
    {
        //echo "Registrando movimentacao<br>";
        $pedido = $event->getPedido();
    //dd($pedido);
        foreach ($pedido->items as $item){
            try{
                DB::beginTransaction();
//baixar estoque
                $produto = $item->product;
                $quantidadeAnterior = $produto->qtd;
                $quantidade = $quantidadeAnterior - $item->qtd;
                $produto->qtd = $quantidade;
                $produto->save();
                $msg = "baixa estoque pedido_id=" . $pedido->id . " produto_id=". $item->product_id . " qtd sai = " . $item->qtd;
                Log::info($msg);
                
                //criar movimentacao
                $movimentacao = Movimentacao::create(
                        [
                            'product_id' => $produto->id,
                            'operacao'=> $this->operacao,
                            'operacao_id'=> $pedido->id,//venda, devolucao, ajuste
                            'qtd' =>$quantidade,
                            'qtd_anterior' => $quantidadeAnterior,
                        ]);
                
                DB::commit();
                Log::info("Movimentacao (saída) criada - " . $movimentacao->id );                
            }
            catch (\Exception $e){
                DB::rollBack();
                Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            }
        }
    }
}
