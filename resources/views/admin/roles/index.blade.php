@extends('layouts.template')

@section('content')
    <h2 class="title">Papéis</h2>

    <a href="{{route('admin.roles.create')}}" class="btn btn-primary">Novo</a>

    <table class="table table-striped table-responsive">
        <thead>
        <tr>
        	<th>Nome</th>
            <th>Label</th>
            <th>Funçoes</th>
        </tr>
        </thead>
        <tbody>
        @foreach($roles as $role)
            <tr>
                <td>{{$role->name}}</td>
                <td>{{$role->label}}</td>
                <td>
                    <a href = "{{route('admin.roles.edit', $role->id) }}" class="btn btn-primary">Editar</a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.roles.delete', $role->id) }}" data-name = "{{$role->name}}" data-msg=" Excluir papel?" data-msg_alert="Atencão só será excluído se não tiver usuário associado.">Excluir</button>
                    <a href = "{{route('admin.roles.permissions', $role->id) }}" class="btn btn-primary">Permissões</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
    <div id="pages">
        {!! $roles->render() !!}
    </div>

    @include('partial.modal_excluir')

@endsection