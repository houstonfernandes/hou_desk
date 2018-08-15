<?php

namespace App\Http\Controllers;

use App\Local;
use App\Role;
use App\Domains\UserRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserUpdateOwnRequest;

class UsersController extends Controller
{
    private $repository;
    public function __construct(UserRepository $repository){
        $this->repository = $repository;
    }
    public function index()
    {
        $users = $this->repository->listaPaginada();
        return view('admin.user.index', compact('users'));
    }
    
    public function create()
    {
        $locais = Local::all();
        return view('admin.user.create', compact('locais'));
    }
    
    public function store(Requests\UserRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.users.index');
    }    

    public function edit($id)
    {
        $locais = Local::all();
        $user = $this->repository->findByID($id);
        return view('admin.user.edit', compact('user', 'locais'));
    }    
    
    public function update( $id, Requests\UserRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.users.index');
    }
    
    public function editOwn()
    {
        $user = Auth::user();
        return view('user.edit_own', compact('user'));
    }
    
    public function updateOwn($id, UserUpdateOwnRequest $request )
    {
        $saida = $this->repository->updateOwn($id, $request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('home');
    }
    
    /*
     *retorna o lembrete de senha para o email cadastrado
     */
    public function lembreteSenha($email)
    {
        //@todo testar
        $saida = $this->repository->lembreteSenha($email);
        return response()->json($saida, $saida['statusCode']);
/*      $user =  $this->users->where('email', $email)->get()->first();
        if(!$user){
            return response()->json(['msg'=>'Email não encontrado.'],404);
        }
        $lembrete = $user->lembrete;
        return response()->json([
            'lembrete' => $lembrete,
        ]);
        */
    }
    
    public function delete($id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.users.index');
    }
    
    public function roles($id, Role $role)
    {
        $user = $this->repository->findByID($id);
        $roles = $role->all();
        return view('admin.user.roles', compact('user', 'roles'));
    }
    
    public function rolesUpdate($id, Request $request)
    {
        $saida = $this->repository->rolesUpdate($id, $request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.users.index');        
    }    
}
