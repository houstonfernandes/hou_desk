@extends('layouts.template')
@section('content')
    @foreach($users as $user)
        <?php Auth::loginUsingId($user->id);?>

        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title">
                    Usuário: {{Auth::user()->name}}
                </h3>
            </div>
            <div class="panel-body">

                @if(count(Auth::user()->roles)>0)
                    <h4>Papéis</h4>
                    <ul>
                        @foreach(Auth::user()->roles as $role)
                            <li>{{$role->name}}</li>
                        @endforeach
                    </ul>
                    <h4>Permissões</h4>
                    @if(isAdmin($user))
                        <div class="alert alert-success" role="alert">ADMINISTRADOR - Acesso total do Sistema</div>
                    @else
                        <table class="table">
                            <thead>
                                <th>nome</th>
                                <th>label</th>
                                <th>permitido</th>
                            </thead>
                            <tbody>
                                @foreach($permissions as $permission)
                                    <tr @if(Gate::allows($permission->name))class="success"@endif>
                                        <td> {{$permission->name}}</td>
                                        <td> {{$permission->label}}</td>
                                        <td>
                                            @if(Gate::allows($permission->name))
                                                <span class="glyphicon glyphicon-ok success" aria-hidden="true"></span>
                                            @else
                                                <span class="glyphicon glyphicon-remove success" aria-hidden="true"></span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            </tbody>
                        </table>
                    @endif
                    @else
                        <div class="alert alert-danger"> Nenhum Papel</div>
                    @endif

             </div>
        </div>

    @endforeach
@endsection
