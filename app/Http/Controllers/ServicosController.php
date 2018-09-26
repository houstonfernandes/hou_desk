<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Http\Requests\EquipamentoRequest;
use App\Http\Requests\MensagemServicoRequest;
use App\Http\Requests\AtenderServicoRequest;
use App\Local;
use App\Domains\ServicoRepository;
use App\TipoServico;
use App\Http\Requests\ServicoRequest;
use App\Events\ServicoCriado;
use App\Events\ServicoFinalizado;


class ServicosController extends Controller
{
    private $repository;
    public function __construct(ServicoRepository $repository){
        $this->repository= $repository;
    }
    
    public function index()    
    {
        $local_id = Auth::user()->local_id;
        $local = Local::find($local_id);
        $servicos = $this->repository->listaPaginadaLocal($local_id);        
        //dd($servicos->count());        
        return view('servicos.index', compact('local', 'servicos'));
    }
    
    public function create()
    {
        $local_id = Auth::user()->local_id;
        $local = Local::find($local_id);
        $tiposServico = TipoServico::all();        
        return view('servicos.create', compact('local', 'tiposServico'));
    }
    
    public function store(ServicoRequest $request)
    {
        $saida = $this->repository->store($request);
        $servico = $saida['servico'];
        if($request->notificar_tecnico==1){
            try{
                event(new ServicoCriado($servico));//evento email p/ técnico;
                
                $servico->situacao = ServicoRepository::STATUS_EMAIL_ENVIADO;
                $servico->save();
                
                $saida['msg'] .='<p class="text-success">Email enviado para o técnico.</p>';
            }catch (\Exception $e){
                Log::error(__METHOD__ . ' Exception: ' . $e->__toString() . '-' . $e->getMessage());
                $saida['msg'] .='<p class="text-danger">Houve falha ao enviar email para o técnico.</p>';                
            }
        }
        
        flash($saida['msg'], $saida['style']);
        
        return redirect()->route('servicos.index');
    }
    
    public function consultar($id){
        $servico = $this->repository->findByID($id);
        //$tiposEquipamentos = TipoEquipamento::ativo()->get();
        
        //se tecnico mudar o status p tecnico ciente
        if(Auth::user()->isTecnico() && $servico->situacao <= ServicoRepository::STATUS_TECNICO_CIENTE ){
            //dd('é tecnico');
            $servico->situacao = ServicoRepository::STATUS_TECNICO_CIENTE;
            $servico->save();
        }
        
        //mensagens = Mensagem
        
        return view('servicos.consultar', compact('servico'));
    }
    

    /**
     * procura fornecedor por diversos campos
     * @param request [nome, ]
     * @return array json
     */
    public function search(Request $request){
        $saida = $this->repository->search($request);
        return response()->json($saida, $saida['statusCode']);
    }
    
    public function storeMensagem(MensagemServicoRequest $request)
    {
        $saida = $this->repository->storeMensagem($request);
        $servicoId = $request->servico_id;
        
        //flash($saida['msg'], $saida['style']);
        
        return redirect()->route('servicos.consultar', $servicoId);
    }
    
    public function atender(AtenderServicoRequest $request)
    {
        $saida = $this->repository->atender($request);
        $servico = $this->repository->findByID($request->servico_id);        
        
        if($request->notificar_solicitante == 1){
            try{
                event(new ServicoFinalizado($servico));//evento email p/ técnico;                
                $saida['msg'] .='<p class="text-success">Email enviado para o solicitante.</p>';
            }catch (\Exception $e){
                Log::error(__METHOD__ . ' Exception: ' . $e->__toString() . '-' . $e->getMessage());
                $saida['msg'] .='<p class="text-danger">Houve falha ao enviar email para o solicitante.</p>';
            }
        }
        
        
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('servicos.index');
    }
    
    
}
