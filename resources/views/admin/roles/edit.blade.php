@extends('layouts.template')
@section('content')

<h2 class="title">Editar Papel</h2>
<h3>{{$role->name}}</h3>

@include("partial.errors")

<div>
    <form action="{{route('admin.roles.update', $role->id)}}" method="post">
        <input type="hidden" name="id" value="{{ $role->id }}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}

        <div class ='form-group'>
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome do perfil para o sistema" value="{{ $role->name }}" required>
        </div>

        <div class="form-group">
            <label for="label">Label</label>
            <input type="text" class="form-control" id="label" name="label" placeholder="Nome a ser exibido" value="{{ $role->label }}" required>
        </div>

        <div class ='form-group'>
            <input type="submit" value='Confirmar' class="btn btn-primary">
            <a class="btn btn-primary" href="{{route('admin.roles.index')}}">Cancelar</a>
        </div>
    </form>
</div>

@endsection