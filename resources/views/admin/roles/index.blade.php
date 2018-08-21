@extends('layouts.template')

@section('content')
    <h2 class="title">Papéis</h2>

    <a href="{{route('admin.roles.create')}}" class="btn btn-primary">
    	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
    	Novo
    </a>

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
                    <a href = "{{route('admin.roles.permissions', $role->id) }}" class="btn btn-primary">
                    	<span class="glyphicon glyphicon-flag" aria-hidden="true" title='Permissões'></span>
                    </a>
                    <a href = "{{route('admin.roles.edit', $role->id) }}" class="btn btn-primary" title='Editar'>
                    	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                    </a>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.roles.delete', $role->id) }}" data-name = "{{$role->name}}" data-msg=" Excluir papel?" data-msg_alert="Atencão só será excluído se não tiver usuário associado." title='Excluir'>
                    	<span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span>                    
                    </button>
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