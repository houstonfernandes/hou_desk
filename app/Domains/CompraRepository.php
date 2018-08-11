<?php
namespace App\Domains;

use App\Compra;
use App\Events\PedidoCriado;
use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Carbon\Carbon;
use App\Events\CompraRecebida;

class CompraRepository extends BaseRepository
{
    protected $modelClass = Compra::class;
    protected $model;
    protected $orderBy = 'created_at';
    protected $orderByDirection = 'desc';
    protected $perPage = 10;
        
    /*
     * armazena um pedido //e dispara evento PedidoCriado 
     * @return id do pedido ou false;
     */
    
    public function store(FormRequest $request)
    {
        $saida=[];
        $msg='';
    /*
    $input = $request->all();
    if($input['status']==0){
        echo 'status 0 entregue';
    }
    
    dd($request->all());
    */
        try{
            DB::beginTransaction();
            
            $input = $request->all();            
            $total = 0;                         //calcular total
            //@info se unidade for un qtd=integer(feito na view mercado)
            foreach ($input['itens'] as $item){
                $total += ($item['valor_compra'] - $item['desconto']) * $item['qtd'];//qtd ate a chegada; total e com qtd_entregue quado aguarda
            }
            $total = $total + $input['frete'] + $input['imposto'];
            $input['total'] = $total;
            if($input['status']==0){//entregue pelo fornecedor com a compra
                $input['data_chegada'] = date('Y-m-d H:i:s');                
            }
            
            $compra = $this->model->fill($input);//dados do request passados para o model
            $compra->save();//persiste no banco
            $msg .='1 - pedido compra Gravado. \n';
            
            foreach ($input['itens'] as $item){//gravar itens
                $qtdEntregue = isset($item['qtd_entregue'])? $item['qtd_entregue']:0;
                
                if($input['status']==0){//entregue pelo fornecedor. qtd entregue é igual pedida 
                    $qtdEntregue = $item['qtd'];
                }
                
                $obs = isset($item['obs'])? $item['obs']:'';
                $compra->items()->create(
                    [
                        'product_id' => $item['id'],//id vem de produto
                        'preco'=> $item['valor_compra'],// valor compra
                        'desconto'=> $item['desconto'],
                        'qtd' => $item['qtd'],
                        'qtd_entregue' => $qtdEntregue,
                        'obs' => $obs,
                    ]);
            }
            $msg .='2 -itens gravados.\n';

            //@todo pagamentos de compras pensar
            
            DB::commit();
            
            $saida['msg'] = ' Compra - criada com sucesso. ' . $compra->id .' - '. $compra->fornecedor->nome . date('Y-m-d H:i:s');;
            $saida['tarefas'] = $msg;
            $saida['statusCode'] =  201;
            
            if($compra->status ==0){//se foi entregue pelo fornecedor 
                $event = event(new CompraRecebida($compra));// adicionar ao estoque @todo contas a pagar ao gerar compra
            }
        }
        catch (\Exception $e){
            DB::rollBack();
            $saida['msg'] = 'Falha ao criar Pedido. - ' . $e->getMessage();
            $saida['tarefas'] = $msg;
            $saida['statusCode'] = 500;
            $saida['exception'] = $e->__toString();
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }
    
    public function update($id, FormRequest $request)
    {
        $saida=[];
        $msg='';
        
        try{
            DB::beginTransaction();            
            
            $input = $request->all();
            $total = 0;   //calcular total
            foreach ($input['itens'] as $item){
                $total += ($item['preco'] - $item['desconto']) * $item['qtd_entregue'];
            }
            $total = $total + $input['frete'] + $input['imposto'];            
            $input['total'] = $total;
            $input['data_chegada'] = date('Y-m-d H:i:s');
            $input['status'] = 0;//entregue

            $compra = $this->findByID($id);
            $compra->update($input);
            
            $msg .='1 - pedido compra atualizado. \n';
            
            foreach ($input['itens'] as $item){//gravar itens
                //$qtdEntregue = isset($item['qtd_entregue'])? $item['qtd_entregue']:0;
                $obs = isset($item['obs'])? $item['obs']:'';
                /*
                $compra->items()->update(
                    [
                        'id' => $item['id'],
                        'product_id' => $item['product_id'],
                        //'compra_id' => $item['compra_id'],
                        'preco'=> $item['preco'],//*** valor compra
                        'desconto'=> $item['desconto'],
                        //'qtd' => $item['qtd'],
                        'qtd_entregue' => $item['qtd_entregue'],
                        'obs' => $obs,
                    ]);
                    */
                $itemCompra = \App\ItemCompra::find($item['id']); //ou \App\ItemCompra::where('id', $item['id'])->update(...);
                $itemCompra->update(
                    [
                        //'id' => $item['id'],
                        //'product_id' => $item['product_id'],
                        //'compra_id' => $item['compra_id'],
                        'preco'=> $item['preco'],//*** valor compra
                        'desconto'=> $item['desconto'],
                        //'qtd' => $item['qtd'],
                        'qtd_entregue' => $item['qtd_entregue'],
                        'obs' => $obs,
                    ]);
                
            }
            $msg .='2 -itens atualizados.\n';
            
            //@todo pagamentos de compras pensar
            
            DB::commit();
            
            $saida['msg'] = ' Compra - atualizada com sucesso. ' . $compra->id .' - '. $compra->fornecedor->nome;
            $saida['tarefas'] = $msg;
            $saida['urlConsultar'] = route('admin.compras.consultar',['id'=>$compra->id]);
            $saida['statusCode'] =  200;
            $event = event(new CompraRecebida($compra));// adicionar ao estoque @todo contas a pagar
        }
        catch (\Exception $e){
            DB::rollBack();
            $saida['msg'] = 'Falha ao criar Pedido. - ' . $e->getMessage();
            $saida['tarefas'] = $msg;
            $saida['statusCode'] = 500;
            $saida['exception'] = $e->__toString();
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }
    
}