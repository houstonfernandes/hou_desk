@extends('layouts.app')

@section('content')
	<h2 class='title'>
    	Editar Categoria
    </h2>    
    
	<form action="{{route('admin.categories.update', $category->id)}}" method="post">
        <input type="hidden" name="id" value="{{$category->id}}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
        
      <div class="form-group">
        <label for="name">Nome</label>
        <input type="text" class="form-control" id="name" name="name" value="{{$category->name}}"aria-describedby="nameHelp" placeholder="nome da categoria">
        <small id="nameHelp" class="form-text text-muted">Nome que define a categoria.</small>
      </div>
      <div class="form-group">
        <label for="description">Descrição</label>
        <textarea class="form-control" id="description" name="description" rows="3">{{$category->description}}</textarea>
      </div>
       <div class="form-check">
            <input type="hidden" name="enabled" value="0"><!-- para desativar se estiver desmarcado -->
            <input type="checkbox" class="form-check-input" id="enabled" name="enabled" value="1" {{$category->enabled==1 ? "checked ":""}}>
            <label class="form-check-label" for="ativo">Ativo</label>
       </div>
      
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.categories.index')}}">Cancelar</a>
	</form>
	
@endsection