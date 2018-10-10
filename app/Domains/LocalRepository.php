<?php
namespace App\Domains;

use App\Local;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\LocalSearch;

class LocalRepository extends BaseRepository
{
    protected $modelClass = Local::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * armazena local
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $local = $this->model->create($request->all());
            $msg = 'Local cadastrado com sucesso. - ' . $local->nome. ': '. $local->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar local.', 'style' =>'danger'];
        }
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $obj = $this->findByID($id);
            $obj->update($input);
            $msg = 'Local atualizado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar local', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $obj = $this->findByID($id);
            $nome = $obj->nome;
            
            if ($this->podeExcluir($obj)){
                $obj->delete();
                $msg = 'Local excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Local ' . $nome .' não pode ser excluído, pois possui usuários.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir local', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Local $obj)
    {
        //@todo verificar em users
        //return true;
        $qtd= count($obj->usuarios);   //verificar usuarios
        return ($qtd == 0)? true:false;        
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
            $objQuery = LocalSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $locais = $objQuery->get();
            if($locais->count()==0){
                throw new NotFoundException('Local não encontrado.');
            }
            
            $saida = [
                'msg' =>'Local encontrado.',
                'locais' => $locais,
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
    
    public function listarSetores($id)
    {
        $saida = [];
        try{
            $local = $this->findByID($id);
            $setores = $local->setores;
            if($setores->count()==0){
                throw new NotFoundException('Nenhum setor foi encontrado.');
            }
            
            $saida = [
                'msg' =>'setor encontrado.',
                'setores' => $setores,
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