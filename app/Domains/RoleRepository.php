<?php
namespace App\Domains;

use App\Role;
use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use App\Exceptions\DadosInvalidosException;
use App\Exceptions\NaoPodeExcluirException;

class RoleRepository extends BaseRepository
{
    protected $modelClass = Role::class;
    protected $model;
    protected $orderBy = 'name';
    protected $orderByDirection = 'asc';
    protected $perPage = 15;    
    
    /**
     * armazena usuario
     * @param FormRequest $request
     * @return array 'sucesso', 'id','erro'
     */
    public function store(FormRequest $request)
    {
        try{
            $input = $request->all();            
            $role = $this->model->fill($input);
            $role->save();
            $msg = 'Papel criado com sucesso. - '.$role->name;
            return ['msg' => $msg, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar Papel', 'style' =>'danger'];
        }
        
    }
    
    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();
            $role = $this->findByID($id);
            $role->update($input);
            $msg = 'Papél atualizado com sucesso. - '.$role->name;
            
            $input = $request->all();            
            $user = $this->findByID($id);
            $user->update($input);
            return ['msg' => $msg, 'style' =>'success'];            
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao atualizar Papel', 'style' =>'danger'];            
        }
    }
    
    public function delete($id)
    {
        try{
            $role = $this->findByID($id);
            $name = $role->name;
            if ($this->podeExcluir($role)){
                $role->delete();
                $msg = 'Papel excluido com sucesso. - '.$role->name;            
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {
                throw new NaoPodeExcluirException('Papel ' . $name .' não pode ser excluída, pois possui usuários.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao excluir papel', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(Role $role)
    {
        $qtdUser = count($role->users);   //verificar users
        return ($qtdUser == 0)? true:false;
    }
    
    public function permissionsUpdate($id, Request $request)
    {
        try{
            $input = $request->all();        
            $role = $this->findByID($id);
            if($role->name=='admin'){
                $msg = "admin não precisa alterar permissões";
            }
            else{                    
                if(!isset($input['permissions'])){//quando desmarcar todas
                    $input['permissions']=null;            
                }
                $role->permissions()->sync($input['permissions']);
                $msg = 'Permissões atualizadas com sucesso. - '.$role->name;
            }
            return ['msg' => $msg, 'style' =>'success'];            
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao alterar permissões de papéis.' , 'style' =>'danger'];
        }
    }
}