<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\PedidoCriado;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Movimentacao;
use App\Events\CompraRecebida;

class ReceberMercadoriaCompra
{
    private $operacao = 0;// 0 => 'Compra',    1 => 'Venda',    2 => 'Devolução',    3 => 'Ajuste'
    
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
    public function handle(CompraRecebida $event)
    {
        //echo "Registrando movimentacao<br>";
        $compra = $event->getCompra();
        foreach ($compra->items as $item){
            try{
                DB::beginTransaction();
//baixar estoque
                $produto = $item->product;
                $quantidadeAnterior = $produto->qtd;
                $quantidade = $quantidadeAnterior + $item->qtd_entregue;//somente após informa quanto foi entregue
                $produto->qtd = $quantidade;
                $produto->save();
                $msg = "Adicionando ao estoque compra_id=" . $compra->id . " produto_id=". $item->product_id . " qtd entra = " . $item->qtd_entregue;
                Log::info($msg);
                
                //criar movimentacao
                $movimentacao = Movimentacao::create(
                        [
                            'product_id' => $produto->id,
                            'operacao'=> $this->operacao,
                            'operacao_id'=> $compra->id,//venda, devolucao, ajuste
                            'qtd' =>$quantidade,
                            'qtd_anterior' => $quantidadeAnterior,
                        ]);
                
                DB::commit();
                Log::info("Movimentacao (entrada) criada. id=" . $movimentacao->id );                
            }
            catch (\Exception $e){
                DB::rollBack();
                Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            }
        }
    }
}
