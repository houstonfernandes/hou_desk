@extends('layouts.template')

@section('content')

<h2 class="title">Novo Papel</h2>

@include("partial.errors")

<div>
    <form action="{{route('admin.roles.store')}}" method="post">
        {{ csrf_field() }}
        <div class ='form-group'>
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome do perfil para o sistema" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="label">Label</label>
            <input type="text" class="form-control" id="label" name="label" placeholder="Nome a ser exibido" value="{{ old('label') }}" required>
        </div>

        <div class="form-group">
            <input type="submit" value='Confirmar' class="btn btn-primary">
            <a class="btn btn-primary" href="{{route('admin.roles.index')}}">Cancelar</a>
        </div>
    </form>
</div>

@endsection
