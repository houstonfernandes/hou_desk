@extends('layouts.app')

@section('content')
	<h2 class='title'>
    	Nova Categoria
    </h2>
    
    
    <form method="post" action="{{route('admin.categories.store')}}" >
    {{ csrf_field() }}
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}"aria-describedby="nameHelp" placeholder="nome da categoria">
        <small id="nameHelp" class="form-text text-muted">Nome que define a categoria.</small>
      </div>
      <div class="form-group">
        <label for="description">Descrição</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{old('description')}}</textarea>
      </div>
      <div class="form-check">
        <input type="checkbox" class="form-check-input" id="enabled" name="enabled">
        <label class="form-check-label" for="enabled">Ativo</label>
      </div>
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.categories.index')}}">Cancelar</a>
	</form>
    
@endsection