<?php
namespace App\Domains;

use App\Category;

use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Exceptions\NotFoundException;
use App\Exceptions\NaoPodeExcluirException;
use App\Search\CategorySearch;

class CategoryRepository extends BaseRepository
{
    protected $modelClass = Category::class;
    protected $model;
    protected $orderBy = 'name';
    protected $orderByDirection = 'asc';
    protected $perPage = 10;    
    
    /**
     * armazena category
     * @param FormRequest $request
     * @return array 'sucesso', 'id','danger'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();
            $category = $this->model->create($input);
            $msg = 'Categoria criada com sucesso. - ' . $category->name. ': '. $category->id;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar categoria.', 'style' =>'danger'];
        }        
    }

    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $category = $this->findByID($id);
            $category->update($input);
            $msg = 'Categoria atualizada com sucesso. - ' . $category->name;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());                        
            return  ['msg' => 'falha ao atualizar categoria.', 'style' =>'danger'];
        }
    }
    
    public function delete($id)
    {
        try{            
            $category = $this->findByID($id);
            $nome = $category->name;
            
            if ($this->podeExcluir($category)){
                $category->delete();
                $msg = 'Categoria ' . $nome . ' excluida com sucesso.';
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Categoria ' . $nome .' não pode ser excluída, pois possui produtos.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());            
            return  ['msg' => 'falha ao excluir categoria', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Category $category)
    {        
        $qtdProdutos = count($category->products);
        return ($qtdProdutos == 0)? true:false;        
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
            $objQuery = CategorySearch::apply($request)
                ->orderBy($this->orderBy, $this->orderByDirection);
            $categorias = $objQuery->get();
            if($categorias->count()==0){
                throw new NotFoundException('Categoria não encontrada.');
            }
            
            $saida = [
                'msg' =>'Categoria encontrada.',
                'categorias' => $categorias,
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