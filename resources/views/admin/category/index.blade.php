@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>
    		Categorias
    	</h2>
	<div>
		<a class="btn btn-primary" href="{{route('admin.categories.create')}}">Nova</a>
	</div>
        	<table class='table table-striped'>
            	<thead>
                	<tr>        	
                		<th>id</th>
                		<th>Nome</th>
                		<th>Descrição</th>
                		<th>Funções</th>
                	</tr>
                </thead>
                <tbody>
                @foreach($categories as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td>{{$category->description}}</td>
                        <td>
                            <a href = "{{route('admin.categories.edit', $category->id) }}" class="btn btn-primary">Editar</a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.categories.delete', $category->id) }}" data-name = "{{$category->name}}" data-msg=" Excluir categoria?" data-msg_alert="Atencão só será excluída se não possuir Produto.">Excluir</button>                        
                        </td>
                    </tr>
                @endforeach
            	</tbody>        	
        	</table>
        </div>
        
        <div id="pages">
        {!! $categories->render() !!}
    </div>

    @include('partial.modal_excluir')
        
@endsection
