<?php

namespace App\Http\Controllers;


use App\Permission;
use App\Role;
use Illuminate\Http\Request;
use App\Http\Requests\RoleRequest;

use App\Http\Requests;
use App\Domains\RoleRepository;

class RolesController extends Controller
{
    private $repository;
    public function __construct(RoleRepository $role){
        $this->repository = $role;
    }

    public function index()
    {
        $roles = $this->repository->listaPaginada();
        return view('admin.roles.index', compact('roles'));
    }

    public function create()
    {
        return view('admin.roles.create');
    }

    public function store(RoleRequest $request)
    {
        $saida = $this->repository->store($request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.roles.index');
    }
    
    public function edit($id)
    {
        $role = $this->repository->findByID($id);
        return view('admin.roles.edit', compact('role'));
    }

    public function update($id, RoleRequest $request)
    {
        $saida = $this->repository->update($id, $request);
        flash($saida['msg'], $saida['style']);        
        return redirect()->route('admin.roles.index');
    }

    public function delete($id)
    {
        $saida = $this->repository->delete($id);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.roles.index', compact('name'));
    }

    public function permissions($id, Permission $permission)
    {
        $role = $this->repository->findByID($id);
        $permissions = $permission->all();
        return view('admin.roles.permissions', compact('role', 'permissions'));
    }

    public function permissionsUpdate( $id, Request $request)
    {
        $saida = $this->repository->permissionsUpdate($id, $request);
        flash($saida['msg'], $saida['style']);
        return redirect()->route('admin.roles.index');
    }
}
