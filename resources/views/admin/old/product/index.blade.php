@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>
    		Produtos
    	</h2>
	<div>
		<a class="btn btn-primary" href="{{route('admin.products.create')}}">Novo</a>
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
                @foreach($products as $product)
                    <tr>
                        <td>{{$product->id}}</td>
                        <td>{{$product->nome}}</td>
                        <td>{{$product->descricao}}</td>
                        <td>
                            <a href = "{{route('admin.product_images.index', $product->id) }}" class="btn btn-primary">Imagens</a>
                            <a href = "{{route('admin.products.edit', $product->id) }}" class="btn btn-primary">Editar</a>
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.products.delete', $product->id) }}" data-name = "{{$product->nome}}" data-msg=" Excluir produto?" data-msg_alert="Atencão só será excluído se não possuir movimentação.">Excluir</button>                                                                            
                        </td>
                    </tr>
                @endforeach
            	</tbody>        	
        	</table>
        </div>
        
        <div id="pages">
        {!! $products->render() !!}
    	</div>

    @include('partial.modal_excluir')
        
@endsection
