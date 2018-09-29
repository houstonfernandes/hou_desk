<?php

namespace App\Domains;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Servico;
use App\Exceptions\NotFoundException;
use App\Search\EquipamentoSearch;

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
    
    
    
}