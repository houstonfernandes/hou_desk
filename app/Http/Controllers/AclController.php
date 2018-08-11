<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

class AclController extends Controller
{
    public function __construct()
    {
        //$this->middleware('auth');
    }
    
    public function testeAcl(){
        //dd(Auth::user());
        if(Gate::allows('user_role')){
        //$user = Auth::user();
        //if(Gate::allows('eum')){
            echo "autorizado";
        }
        else
            echo 'não autorizado!!!!';
    }

    public function todasPermissoesSistema(){
        //Auth::loginUsingId(3);//testar login
        $user = auth()->user();
        $permissions = \App\Permission::all();
        return view('teste.acl.todas_permissions', compact('permissions','user'));
    }

    /*
     * lista todas permissõe para o user logado
     * */
    public function permissoes()
    {
        $user = auth()->user();
        echo'<h3>' . $user->name . "</h3>";
        echo'<h4>roles </h4>';

        echo'<ul>';
        foreach($user->roles as $role) {
            echo '<h3>' . $role->name . ' - ' . $role->label  . "</h3>";
            foreach($role->permissions as $permission) {
                echo '<li>' . $permission->name . "</li>";
            }


        }
        echo "</ul>";
    }

    public function rolesPermissions()
    {
        $user = auth()->user();
        return view('teste.acl.roles_permissions', compact('user'));
    }

    /**
     * verifica todas permissões para todos usuarios
     * */
    public function todasPermissoesSistemaTodosUsers(){
        //Auth::loginUsingId(3);//testar login
        $users = \App\User::all();
        $permissions = \App\Permission::all();
        return view('teste.acl.todas_permissions_todos_users', compact('permissions','users'));
    }

}
