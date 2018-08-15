<?php
namespace App\Domains;

use App\Cliente;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\ClienteSearch;

class ClienteRepository extends BaseRepository
{
    protected $modelClass = Cliente::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * armazena produto
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $cliente = $this->model->create($request->all());
            $msg = 'Cliente cadastrado com sucesso. - ' . $cliente->nome. ': '. $cliente->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar cliente', 'style' =>'danger'];
        }
        
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $cliente = $this->findByID($id);
            $cliente->update($input);
            $msg = 'Cliente atualizado com sucesso. - ' . $cliente->nome. ': '. $cliente->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar cliente', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $cliente = $this->findByID($id);            
            $nome = $cliente->nome;            
            if ($this->podeExcluir($cliente)){
                $cliente->delete();
                $msg = 'Cliente excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Cliente ' . $nome .' não pode ser excluído, pois possui pedidos.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir cliente', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Cliente $cliente)
    {
        $qtdPedidos = count($cliente->pedidos);   //verificar pedidos
        return ($qtdPedidos == 0)? true:false;        
    }
    
    /**
     * procura produto por diversos campos
     * @param request [nome, marca, cod_barra]
     * @return array json
     */
    public function search(Request $request)
    {
        $saida = [];
        try{
            $clientesQuery = ClienteSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $clientes = $clientesQuery->get();
            if($clientes->count()==0){
                throw new NotFoundException('Cliente não encontrado.');
            }
            
            $saida = [
                'msg' =>'cliente encontrado.',
                'clientes' => $clientes,
                'statusCode' => 200
            ];            
        }
        catch (NotFoundException $e){
            $saida = [
                'msg' => $e->getMessage(),
                'statusCode' => $e->getCode()
            ];
            
        }
        catch (\Exception $e){
            $saida = [
                'msg' => $e->getMessage(),
                'statusCode' => $e->getCode()
            ];
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
        }
        return $saida;            
    }
}