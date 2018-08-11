@extends('layouts.template')
@section('content')
    <h3>Usuário: {{$user->name}}</h3>

    @if(isAdmin($user))
        <div class="alert alert-success" role="alert">ADMINISTRADOR - Acesso total do Sistema</div>
    @else
        <h4>Papéis </h4>
        @foreach($user->roles as $role)
            <div class="panel panel-primary">
                <div class="panel-heading">{{$role->label}}</div>
                    <table class="table">

                        <tbody>
                        @foreach($role->permissions as $permission)
                            <tr>
                                <td> {{$permission->name}}</td>
                                <td> {{$permission->label}}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
            </div>
        @endforeach
    @endif
@endsection
