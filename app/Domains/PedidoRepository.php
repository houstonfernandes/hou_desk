<?php
namespace App\Domains;

use App\Pedido;
use App\Events\PedidoCriado;
use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PedidoRepository extends BaseRepository
{
    protected $modelClass = Pedido::class;
    protected $model;
    protected $orderBy = 'created_at';
    protected $orderByDirection = 'desc';
    protected $perPage = 15;
        
    /*
     * armazena um pedido e dispara evento PedidoCriado 
     * @return id do pedido ou false;
     */
    
    public function store(FormRequest $request)
    {
        $saida=[];
        $msg='';
        try{
            DB::beginTransaction();
            
            $input = $request->all();
            
            $total = 0;                         //calcular total
            //@todo se unidade for un qtd=integer(feito na view mercado)
            foreach ($input['itens'] as $item){
                $total += $item['preco'] * $item['qtd'];
            }
            $input['total'] = $total;
            $pedido = $this->model->fill($input);//dados do request passados para o model
            $pedido->save();//persiste no banco
            $msg .='1 - pedido Gravado. \n';
            
            foreach ($input['itens'] as $item){//gravar itens
                $pedido->items()->create(
                    [
                        'product_id' => $item['id'],
                        'preco'=> $item['preco'],
                        'desconto'=> $item['desconto'],
                        'qtd' => $item['qtd']
                    ]);
            }
            $msg .='2 -itens gravados.\n';
            
            $saldo = $total;
            foreach ($input['pagamentos'] as $item){//gravar pagamentos
                $saldo -= $item['valor'];
                if($saldo < 0){//quando saldo for negativo gravar tirar restante do pagamento(troco)
                    $item['valor'] += $saldo;
                }
                $pedido->pagamentos()->create(
                    [
                        'tipo' => $item['forma_id'],
                        'valor'=> $item['valor']
                    ]);
                if($saldo < 0){//quando saldo for negativo gravar tirar restante do pagamento(troco) gravar e sair do loop
                    break;
                }
                
            }
            $msg .='3 -pagamentos gravados.\n';
            
            DB::commit();
            
            $saida['msg'] = ' Pedido - criado com sucesso.\n ' . $pedido->id .' - '. $pedido->cliente->nome . '\n';
            $saida['tarefas'] = $msg;
            $saida['statusCode'] =  200;
            $event = event(new PedidoCriado($pedido));
        }
        catch (\Exception $e){
            DB::rollBack();
            $saida['tarefas'] = $msg;
            $saida['msg'] = 'Falha ao criar Pedido. - ' . $e->getMessage();
            $saida['exception'] = $e->__toString();
            $saida['statusCode'] = 500;
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
        }
        return $saida;
    }
}