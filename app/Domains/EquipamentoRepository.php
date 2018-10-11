<?php
namespace App\Domains;

use App\Equipamento;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
    
    const  STATUS_INATIVO = 0;
    const  STATUS_ATIVO = 1;
    const  STATUS_MANUTENCAO = 2;
    const  STATUS_MANUTENCAO_OK = 3;
    
    
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
     * lista equipamentos por local
     * @param int local_id
     * @return array json
     */
    public function listarLocal($localId)
    {
        $saida = [];
        try{
            $query = $this->newQuery();
            $query->select('equipamentos.*','locais.nome AS local_nome', 'locais.id AS local_id', 'setores.id AS setor_id');
            $query->join('setores', 'equipamentos.setor_id', '=', 'setores.id');
            $query->join('locais', 'setores.local_id', '=', 'locais.id');
            $query->where('local_id', $localId)
            ->orderBy('equipamentos.' . $this->orderBy, $this->orderByDirection);
            $result = $query->get();
            $qtd = $result->count();
            if($qtd == 0){
                throw new NotFoundException('Nenhum equipamento encontrado.');
            }
            
            $saida = [
                'msg' => $qtd . ' equipamentos.',
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
    
    /**
     * lista equipamentos por setor
     * @param int setor id
     * @param boolean ativo
     * @return array json
     */
    public function listarSetor($id, $ativo=true)
    {
        $saida = [];
        try{
            $query = $this->newQuery();
            
            $query->select('equipamentos.*');
            $query->where('setor_id', $id);
            $query->where('situacao', '>=', self::STATUS_ATIVO);           //somente ativos
            $query->orderBy('equipamentos.' . $this->orderBy, $this->orderByDirection);
            $result = $query->get();
            $qtd = $result->count();
            if($qtd == 0){
                throw new NotFoundException('Nenhum equipamento encontrado.');
            }
            $saida = [
                'msg' => $qtd . ' equipamentos.',
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
    
    /**
     * procura equipamentos por diversos campos
     * @param request [situacao, local, tipo, setor]
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
    
    /**
     * procura equipamentos por diversos campos
     * @param request [situacao, local, tipo, setor]
     * @return array json
     */
    public function relatorioDescritivo(Request $request)
    {
        $saida = [];
        try{
            $objQuery = EquipamentoSearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);                        
//            $whereString = $this->getWhereString($request);
            
            $objQuery
                ->select('equipamentos.nome', 'equipamentos.descricao', 'equipamentos.num_etiqueta', 'equipamentos.num_patrimonio', 'equipamentos.situacao', 'equipamentos.setor_id', 'st.nome AS setor_nome', 'lc.nome AS local_nome', 'te.nome AS tipo_equipamento_nome')
                    ->join('tipos_equipamento AS te', 'equipamentos.tipo_equipamento_id', '=', 'te.id')
                    ->join('setores AS st', 'equipamentos.setor_id', '=', 'st.id')
                    ->join('locais AS lc', 'st.local_id', '=', 'lc.id');
                //@todo ordenar por mais de um campo

                    if($request->local_id) {
                        $objQuery->where('lc.id', '=', $request->local_id);                        
                        session(['rel_local_id' => $request->local_id]);                        
                    }else{
                        session()->pull('rel_local_id');
                    }
                    if($request->setor_id) {
                        $objQuery->where('st.id', '=', $request->setor_id);
                        session(['rel_setor_id' => $request->setor_id]);
                    }else{
                        session()->pull('rel_setor_id');
                    }
                    if($request->tipo_equipamento_id) {
                        session(['rel_tipo_equipamento_id' => $request->tipo_equipamento_id]);
                    }else{
                        session()->pull('rel_tipo_equipamento_id');
                    }
                    if($request->situacao != null) {
                        session(['rel_situacao' => $request->situacao]);
                    }else{
                        session(['rel_situacao' => null]);
                    }
                                
            $result = $objQuery->get();
            if($result->count()==0){
                throw new NotFoundException('equipamento' . ' não encontrado.');
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
                'equipamentos'=>[],
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

    /**
     * procura equipamentos por diversos campos
     * @param request [situacao, local, tipo, setor]
     * @return array json
     */
    public function relatorioQuantitativo(Request $request)
    {
        $saida = [];
        try{
            $objQuery = EquipamentoSearch::apply($request);
            //->orderBy($this->orderBy, $this->orderByDirection);
            //            $whereString = $this->getWhereString($request);
            
            $objQuery
            ->select(DB::raw('count(equipamentos.id) AS quantidade'), 'lc.nome AS local_nome', 'lc.id AS local_id')
            ->join('tipos_equipamento AS te', 'equipamentos.tipo_equipamento_id', '=', 'te.id')
            ->join('setores AS st', 'equipamentos.setor_id', '=', 'st.id')
            ->join('locais AS lc', 'st.local_id', '=', 'lc.id')
            
            //                ->orderBy('sub_tipo', 'asc')//@todo ordenar por mais de um campo
            ->orderBy('lc.nome', 'asc');
            //->get();
            
            if($request->local_id) {//se passar local_id, agrupar por setor
                $objQuery                
                    ->groupBy('st.id')
                    ->where('lc.id', '=', $request->local_id);
                session(['rel_local_id' => $request->local_id]);
            }else{//se não, agrupar por local
                $objQuery                    
                    ->groupBy('lc.id');                
                session()->pull('rel_local_id');
            }
            
            if($request->tipo_equipamento_id) {
                session(['rel_tipo_equipamento_id' => $request->tipo_equipamento_id]);
            }else{
                session()->pull('rel_tipo_equipamento_id');
            }
            if($request->situacao != null) {
                session(['rel_situacao' => $request->situacao]);
            }else{
                session(['rel_situacao' => null]);
            }
            
            $result = $objQuery->get();
            if($result->count()==0){
                throw new NotFoundException('equipamento' . ' não encontrado.');
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
                'equipamentos'=>[],
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