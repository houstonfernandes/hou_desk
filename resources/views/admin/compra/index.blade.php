@extends('layouts.app')

@section('content')
	<div>
		<a class="btn btn-primary" href="{{route('admin.compras.create')}}">Nova</a>
	</div>
	
    <div class="row">
    	<h2 class='title'>Compras</h2>
        	<table class='table table-striped'>
            	<thead>
                	<tr>        	
                		<th>id</th>
                		<th>Fornecedor</th>
                		<th>Total</th>
                		<th>Data</th>
                		<th>Status</th>
                		<th>Usuário</th>
                		<th>Funções</th>
                	</tr>
                </thead>
                <tbody>
                @foreach($compras as $compra)
                    <tr>
                        <td>{{$compra->id}}</td>
                        <td>{{$compra->fornecedor->nome}}</td>
                        <td>R$ {{number_format($compra->total,2)}}</td>
                        <td>{{date_format($compra->created_at, 'd/m/Y H:i')}}</td>
                        <td>
                        @if ($compra->status == 0)
                        	<span class="glyphicon glyphicon-ok" aria-hidden="true" title="{{$statusCompras[0]}}"></span>
                        	@elseif ($compra->status == 1)
                        	<span class="glyphicon glyphicon-time danger" aria-hidden="true" title="{{$statusCompras[1]}}"></span>
                        @endif
                        </td>
                        <td>{{$compra->user->name}}</td>
                        <td>
                            <a href = "{{route('admin.compras.consultar', $compra->id) }}" class="btn btn-primary">Consultar</a>
                            @if ($compra->status == 1)
                            	<a href = "{{route('admin.compras.edit', $compra->id) }}" class="btn btn-primary">Receber mercadoria</a>
                            @endif
                        </td>
                    </tr>
                @endforeach
            	</tbody>        	
        	</table>
        </div>
        
        <div id="pages">
        {!! $compras->render() !!}
    	</div>

    @include('partial.modal_excluir')
        
@endsection
