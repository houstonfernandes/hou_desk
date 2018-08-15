@extends('layouts.template')


@section('content')
    <h2 class="title">Usuários</h2>

    <a href="{{route('admin.users.create')}}" class="btn btn-primary">
    	<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
    	Novo
    </a>

    <table class="table table-striped table-responsive">
        <thead>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Perfis</th>
            <th>Funçoes</th>
<!--            <th>Endereço</th>
            <th>Número</th>
            <th>Complemento</th>
            <th>Bairro</th>
            <th>Cidade</th>
            <th>UF</th>
            <th>CEP</th>-->
        </tr>
        </thead>
        <tbody>
        @foreach($users as $user)
            <tr>
                <td>{{$user->name}}</td>
                <td>{{$user->email}}</td>
                <td>
                    <ul>
                    @foreach ($user->roles as $role)
                        <li> {{$role->name}} </li>
                    @endforeach
                    </ul>

                </td>
                <td>
                    <a href = "{{route('admin.users.edit', $user->id) }}" class="btn btn-primary" title='Editar'>
                    	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                    </a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.users.delete', $user->id) }}" data-name = "{{$user->name}}" data-msg=" Excluir usuário?" data-msg_alert="Atencão só será excluído se não tiver realizado operação no sistema." title='Excluir'>
                    	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
                    </button>
                    <a href = "{{route('admin.users.roles', $user->id) }}" class="btn btn-primary" title='Papéis'>
                    	<span class="glyphicon glyphicon-user" aria-hidden="true"></span>
                    </a>
                </td>
        @endforeach
        </tbody>
    </table>
    <div id="pages">
        {!! $users->render() !!}
    </div>

    @include('partial.modal_excluir')

@endsection
