<?php

namespace App\Domains;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Servico;
use App\Exceptions\NotFoundException;
use App\Search\EquipamentoSearch;
use App\Search\ServicoSearch;

class ServicoRepository extends BaseRepository
{
    protected $modelClass = Servico::class;
    protected $model;
    protected $orderBy = 'created_at';
    protected $orderByDirection = 'desc';
    protected $perPage = 20;
    private $_nome = 'Servico';
    private $_tabela = 'servicos';
    
    const STATUS_CRIADO = 0;
    const STATUS_EMAIL_ENVIADO = 1;
    const STATUS_TECNICO_CIENTE = 2;
    const STATUS_A_EXECUTAR = 3;
    const STATUS_EM_EXECUCAO = 4;
    const STATUS_FINALIZADO = 5;
    
    /**
     * lista paginada para index - serviços por local
     */
    public function listaPaginadaLocal($id)
    {
        $query = $this->newQuery();
        $query->select($this->_tabela . '.*', 'locais.id AS local_id', 'locais.nome AS local_nome');
        $query->join('users', 'servicos.solicitante_id', '=', 'users.id');
        $query->join('locais', 'users.local_id', '=', 'locais.id');
        $query->where('local_id', $id)
            ->orderBy($this->orderBy, $this->orderByDirection);
        return $this->doQuery($query, $this->perPage, true);
    }
        
    /**
     * armazena serviço
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{    
            $input = $request->all();
            $input['solicitante_id'] = Auth::user()->id;
            $obj = $this->model->create($input);
            $msg = 'Solicitação de serviço criada com sucesso. ' . $obj->id;
            return ['msg' => $msg, 'style' =>'success', 'servico' => $obj];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar '  .$this->_nome, 'style' =>'danger'];
        }
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
    
    /**
     * armazena mensagem de serviço
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function storeMensagem(FormRequest $request)
    {
        try{
            $input = $request->all();
            $input['user_id'] = Auth::user()->id;
            $input['situacao'] = 0;
            $modelMensagem = new \App\MensagemServico();
            $obj = $modelMensagem->create($input);
            $msg = 'Mensagem criada com sucesso. ' . $obj->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar '  .$this->_nome, 'style' =>'danger'];
        }
    }

    /**
     * armazena atendimento do servico, mudando a situacao e armazenando a solução, se finalizado
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function atender(FormRequest $request)
    {
        try{
            $input = $request->all();            
            $obj = $this->findByID($request->servico_id);
            if($input['situacao'] == self::STATUS_FINALIZADO){
                $input['data_solucao'] = new \DateTime();                
            }
            $obj->update($input);
            $msg = 'Serviço <strong>' . $obj->equipamento->setor->local->nome . ' - '  . $obj->equipamento->setor->nome . ' -> ' .  $obj->equipamento->nome . ' - '. $obj->tipoServico->nome . '</strong> atualizado com sucesso.';
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar '  .$this->_nome, 'style' =>'danger'];
        }
    }
    
    /**
     * rel. serviços quantitativos
     * @param request [situacao, local, tipo, setor]
     * @return array json
     */
    public function relatorioQuantitativo(Request $request)
    {
        $saida = [];
        try{
            $objQuery = ServicoSearch::apply($request);
            //->orderBy($this->orderBy, $this->orderByDirection);
            //            $whereString = $this->getWhereString($request);
            
            $objQuery            
            ->join('tipos_servico AS ts', 'servicos.tipo_servico_id', '=', 'ts.id')
            ->join('equipamentos AS eq', 'servicos.equipamento_id', '=', 'eq.id')            
            ->join('tipos_equipamento AS te', 'eq.tipo_equipamento_id', '=', 'te.id')
            ->join('setores AS st', 'eq.setor_id', '=', 'st.id')
            ->join('locais AS lc', 'st.local_id', '=', 'lc.id')
//@todo ordenar por mais de um campo
            ->orderBy('lc.nome', 'asc');
            
            
            
            if($request->local_id) { //se passar local_id, agrupar por setor
                $objQuery
                    ->select(DB::raw('count(servicos.id) AS quantidade'), 'st.nome AS local_nome', 'lc.id AS local_id')
                    ->groupBy('st.id')
                    ->where('lc.id', '=', $request->local_id);
                session(['rel_local_id' => $request->local_id]);
            }else{//se não, agrupar por local
                $objQuery
                    ->select(DB::raw('count(servicos.id) AS quantidade'), 'lc.nome AS local_nome', 'lc.id AS local_id')
                    ->groupBy('lc.id');
                session()->pull('rel_local_id');
            }
            
            if($request->tipo_equipamento_id != null) {
                $objQuery                
                ->where('te.id', '=', $request->tipo_equipamento_id);                
                session(['rel_tipo_equipamento_id' => $request->tipo_equipamento_id]);
            }else{
                session()->pull('rel_tipo_equipamento_id');
            }
     //dd($request->tipo_servico_id);            
            if($request->tipo_servico_id != null) {
                    $objQuery
                    ->where('ts.id', '=', $request->tipo_servico_id);
                    session(['rel_tipo_servico_id' => $request->tipo_servico_id]);
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
                throw new NotFoundException('serviço' . ' não encontrado.');
            }
            
            $saida = [
                'msg' =>'serviço encontrado.',
                'servicos' => $result,
                'statusCode' => 200
            ];
        }
        catch (NotFoundException $e){
            $saida = [
                'msg' => $e->getMessage(),
                'servicos'=>[],
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