<?php
namespace App\Domains;

use App\Equipamento;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\EquipamentoSearch;

class EquipamentoRepository extends BaseRepository
{
    protected $modelClass = Equipamento::class;
    protected $model;
    protected $orderBy = 'nome';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;
    private $_nome = 'Equipamento';
    
    /**
     * lista paginada para index - equipamentos por local
     */
    public function listaPaginadaLocal($id)
    {
        $query = $this->newQuery();
        $query->select('equipamentos.*','locais.nome AS local_nome', 'locais.id AS local_id', 'setores.id AS setor_id');
        $query->join('setores', 'equipamentos.setor_id', '=', 'setores.id');
        $query->join('locais', 'setores.local_id', '=', 'locais.id');
        $query->where('local_id', $id)
            ->orderBy('equipamentos.' . $this->orderBy, $this->orderByDirection);
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
            $input['data_aquisicao'] = dataGravar($request->data_aquisicao);
            //dd($this->data_aquisicao);
            
            $obj = $this->model->create($input);
            $msg = $this->_nome . ' cadastrado com sucesso. - ' . $obj->nome. ': '. $obj->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar '  .$this->_nome, 'style' =>'danger'];
        }
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $input['data_aquisicao'] = dataGravar($request->data_aquisicao);            
            $obj = $this->findByID($id);
            $obj->update($input);
            $msg = $this->_nome .' atualizado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar ' . $this->_nome, 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $obj = $this->findByID($id);
            $nome = $obj->nome;
            
            if ($this->podeExcluir($obj)){
                $obj->delete();
                $msg = $this->_nome . ' excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException($this->_nome. ' ' . $nome .' não pode ser excluído, pois possui serviços.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir ' . $this->_nome, 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Equipamento $obj)
    {
        $qtd= count($obj->servicos);   
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
            $objQuery = EquipamentoSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $result = $objQuery->get();
            if($result->count()==0){
                throw new NotFoundException($this->_nome . ' não encontrado.');
            }
            
            $saida = [
                'msg' =>$this->_nome . ' encontrado.',
                'equipamentos' => $result,
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