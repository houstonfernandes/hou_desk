<?php
namespace App\Domains;

use App\TipoEquipamento;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NaoPodeExcluirException;
use App\TipoServico;

class TipoServicoRepository extends BaseRepository
{
    protected $modelClass = TipoServico::class;
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
            $obj = $this->model->create($request->all());
            $msg = 'Tipo de Serviço cadastrado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar Tipo de Serviço.', 'style' =>'danger'];
        }
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $obj = $this->findByID($id);
            $obj->update($input);
            $msg = 'Tipo de serviço atualizado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar Tipo de serviço', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $obj = $this->findByID($id);
            $nome = $obj->nome;
            
            if ($this->podeExcluir($obj)){
                $obj->delete();
                $msg = 'Tipo de serviço excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Tipo de serviço ' . $nome .' não pode ser excluído, pois possui associações.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir Tipo de serviço', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(TipoServico $obj)
    {
        $qtd = count($obj->servicos);
//        $qtd += count($obj->componentes);
        return ($qtd == 0)? true:false;        
    }
}