<?php
namespace App\Domains;

use App\TipoEquipamento;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NaoPodeExcluirException;

class TipoEquipamentoRepository extends BaseRepository
{
    protected $modelClass = TipoEquipamento::class;
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
            $msg = 'Tipo de Equipamento cadastrado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar Tipo de Equipamento.', 'style' =>'danger'];
        }
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $obj = $this->findByID($id);
            $obj->update($input);
            $msg = 'Tipo de Equipamento atualizado com sucesso. - ' . $obj->nome;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar Tipo de Equipamento', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{
            $obj = $this->findByID($id);
            $nome = $obj->nome;
            
            if ($this->podeExcluir($obj)){
                $obj->delete();
                $msg = 'Tipo de Equipamento excluido com sucesso. - '. $nome;
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Tipo de Equipamento ' . $nome .' não pode ser excluído, pois possui associações.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir Tipo de Equipamento', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(TipoEquipamento $obj)
    {
        $qtd = count($obj->equipamentos);
        $qtd += count($obj->componentes);
        return ($qtd == 0)? true:false;        
    }
}