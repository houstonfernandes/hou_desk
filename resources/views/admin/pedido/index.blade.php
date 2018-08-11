@extends('layouts.app')

@section('content')
	<div>
		<a class="btn btn-primary" href="{{route('admin.pedidos.create_mercado')}}">Novo mercado</a>
	</div>
	
    <div class="row">
    	<h2 class='title'>Pedidos</h2>
        	<table class='table table-striped'>
            	<thead>
                	<tr>        	
                		<th>id</th>
                		<th>Cliente</th>
                		<th>Total</th>
                		<th>Data</th>
                		<th>Usuário</th>
                		<th>Funções</th>
                	</tr>
                </thead>
                <tbody>
                @foreach($pedidos as $pedido)
                    <tr>
                        <td>{{$pedido->id}}</td>
                        <td>{{$pedido->cliente->nome}}</td>
                        <td>R$ {{number_format($pedido->total,2)}}</td>
                        <td>{{date_format($pedido->created_at, 'd/m/Y H:i')}}</td>
                        <td>{{$pedido->user->name}}</td>
                        <td>
                            <a href = "{{route('admin.pedidos.consultar', $pedido->id) }}" class="btn btn-primary">Consultar</a>
                        </td>
                    </tr>
                @endforeach
            	</tbody>        	
        	</table>
        </div>
        
        <div id="pages">
        {!! $pedidos->render() !!}
    	</div>

    @include('partial.modal_excluir')
        
@endsection
