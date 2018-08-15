<?php
namespace App\Domains;

use App\Setor;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\SetorSearch;

class SetorRepository extends BaseRepository
{
    protected $modelClass = Setor::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * lista paginada para index
     */
    public function listaPaginadaLocal($id)
    {
        $query = $this->newQuery();
        $query->where('local_id', $id)
            ->orderBy($this->orderBy, $this->orderByDirection);
        return $this->doQuery($query, $this->perPage, true);
    }
    
    
    /**
     * armazena local
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $obj = $this->model->create($request->all());
            $msg = 'Setor cadastrado com sucesso. - ' . $obj->nome. ': '. $obj->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar setor.', 'style' =>'danger'];
        }
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $obj = $this->findByID($id);
            $obj->update($input);
            $msg = 'Setor atualizado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar setor', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $obj = $this->findByID($id);
            $nome = $obj->nome;
            
            if ($this->podeExcluir($obj)){
                $obj->delete();
                $msg = 'Setor excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Setor ' . $nome .' não pode ser excluído, pois possui equipamentos.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir setor', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Setor $obj)
    {
        $qtd= count($obj->equipamentos);   
        return ($qtd == 0)? true:false;        
    }
    
    /**
     * procura setores por diversos campos
     * @param request [nome, marca, cod_barra]
     * @return array json
     */
    public function search(Request $request)
    {
        $saida = [];
        try{
            $objQuery = SetorSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $setores = $objQuery->get();
            if($setores->count()==0){
                throw new NotFoundException('Setor não encontrado.');
            }
            
            $saida = [
                'msg' =>'Setor encontrado.',
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