<?php
namespace App\Domains;

use App\Fornecedor;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\FornecedorSearch;

class FornecedorRepository extends BaseRepository
{
    protected $modelClass = Fornecedor::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * armazena fornecedor
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $fornecedor = $this->model->create($request->all());
            $msg = 'Fornecedor cadastrado com sucesso. - ' . $fornecedor->nome. ': '. $fornecedor->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar fornecedor.', 'style' =>'danger'];
        }        
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $fornecedor = $this->findByID($id);
            $fornecedor->update($input);
            $msg = 'Fornecedor atualizado com sucesso. - ' . $fornecedor->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar fornecedor', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $fornecedor = $this->findByID($id);
            $nome = $fornecedor->nome;
            
            if ($this->podeExcluir($fornecedor)){
                $fornecedor->delete();
                $msg = 'Fornecedor excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Fornecedor ' . $nome .' não pode ser excluído, pois possui compras.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir fornecedor', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Fornecedor $fornecedor)
    {
        //@todo verificar em compras para excluir
        return true;
        $qtdPedidos = count($fornecedor->compras);   //verificar compras
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
            $objQuery = FornecedorSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $fornecedores = $objQuery->get();
            if($fornecedores->count()==0){
                throw new NotFoundException('Fornecedor não encontrado.');
            }
            
            $saida = [
                'msg' =>'Fornecedor encontrado.',
                'fornecedores' => $fornecedores,
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