<?php
namespace App\Domains;

use App\User;
use App\Support\Repositories\BaseRepository;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use App\Exceptions\NotFoundException;
use App\Exceptions\DadosInvalidosException;
use App\Exceptions\NaoPodeExcluirException;

class UserRepository extends BaseRepository
{
    protected $modelClass = User::class;
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
            $password = $input['password'];
            $input['password'] = bcrypt($password);            
            $user = $this->model->fill($input);//dados do request passados para o model
            $user->save();//persiste no banco            
            return ['msg' => 'Usuário criado com sucesso. - ' . $user->name, 'style' =>'success'];
        }
        catch(\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao gravar usuário', 'style' =>'danger'];
        }
        
    }
    
    public function update($id, FormRequest $request)
    {
        try{
            $input = $request->all();            
            $user = $this->findByID($id);
            $user->update($input);
            return ['msg' => 'Usuário atualizado com sucesso. - ' . $user->name, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao atualizar usuário', 'style' =>'danger'];
        }
    }
    
    public function updateOwn($id, FormRequest $request)
    {     
        try{
            $input = $request->all();
            if (! Hash::check($input['password_old'],Auth::user()->password)){
                throw new DadosInvalidosException('Senha atual está incorreta');                
            }
            $user = $this->findByID($id);        
            $input['password'] = bcrypt($input['password']);//criptografa password        
            $user->update($input);
            return ['msg' => 'Usuário atualizado com sucesso. - ' . $user->name, 'style' =>'success'];
        }
        catch (DadosInvalidosException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }        
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao atualizar usuário', 'style' =>'danger'];
        }        
    }

    public function lembreteSenha($email)
    {
        $saida =[];
        $query = $this->newQuery();
        $user =  $query->where('email', $email)
            ->get()
            ->first();
        try{
            if(!$user){                
                throw new NotFoundException('Email não encontrado.');
            }
            $lembrete = $user->lembrete;
            $saida = [
                'msg' => 'Email encontrado.',
                'lembrete' => $lembrete,
                'statusCode' => 200
            ];
        }
        catch (NotFoundException $e){            
                $saida = [
                    'msg' => $e->getMessage(),
                    'statusCode' => $e->getCode()
                ];
        }
        return $saida;
    }

    public function delete($id)
    {
        try{
            $user = $this->findByID($id);
            $nome = $user->name;
            if ($this->podeExcluir($user)){
                $user->delete();
                $msg = 'Usuário '. $nome.' excluido com sucesso.';
                return ['msg' => $msg, 'style' =>'success'];
            }
            else {            
                throw new NaoPodeExcluirException('Usuário ' . $nome .' não pode ser excluído, pois possui operações no sistema.');
            }
        }
        catch (NaoPodeExcluirException $e){
            return  ['msg' => $e->getMessage(), 'style' =>'danger'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao excluir usuário', 'style' =>'danger'];
        }
    }
    
    private function podeExcluir(User $user)
    {
        //@todo ver key
        $qtdSolicitados = count($user->servicosSolicitados);   //verificar servicos
        $qtdExecutados = count($user->servicosExecutados);
        if($user->isTecnico())//tecnico não pode ser excluido
            return false;
        if($qtdSolicitados > 0 || $qtdExecutados > 0) 
            return false;        
        return true;        
    }
    
    public function rolesUpdate( $id, Request $request)
    {
        try{
            $input = $request->all();        
            $user = $this->findByID($id);
            if(!isset($input['roles'])){//quando desmarcar todas
                $input['roles']=null;
            }
            $user->roles()->sync($input['roles']);
            return ['msg' => 'Papéis do usuário atualizados com sucesso. - '.$user->name, 'style' =>'success'];
        }
        catch (\Exception $e){
            Log::error(__METHOD__ . ' Exception: ' . $e->getMessage());
            return  ['msg' => 'falha ao atualizar papéis de usuário' , 'style' =>'danger'];
        }
    }    
}