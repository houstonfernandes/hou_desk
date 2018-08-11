@extends('layouts.template')
@section('content')
    <h3>Usuário: {{Auth::user()->name}}</h3>

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
@endsection
