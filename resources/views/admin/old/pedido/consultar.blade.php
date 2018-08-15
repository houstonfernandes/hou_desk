@extends('layouts.app')

@section('content')

    <h2 class='title'>Pedido {{$pedido->id}}</h2>    
    
        <div class="form-inline">
            <label for="nome">Número</label>
            <input class="form-control" value="{{$pedido->id}}" readonly>        
            <label for="nome">Data</label>
            <input class="form-control" value="{{ date_format($pedido->created_at, 'd/m/Y H:i') }}" readonly>
        </div>

	<form action="#" name="form">
    	<div class="form-group">
            <label for="name">Cliente</label>
            <input class="form-control" value="{{ $pedido->cliente->nome}}" readonly>
		</div>
            
        <div class="form-group">
            <label for="cod_barra">Vendedor</label>
            <input class="form-control" value="{{ $pedido->user->name}}" readonly>
        </div>
        
        <div>
        	<h3>Itens</h3>
        	<table class='table'>
            	<thead>
                	<tr>
                		<th>Produto</th>
                		<th>Quantidade</th>
                		<th>Unid.</th>
                		<th>Preco unit</th>
                		<th>Preco total</th>
                	</tr>
            	</thead>
            	<tbody>            	
        		@forelse($pedido->items as $item)
        			<tr>
        				<td>{{$item->product->nome}}</td>
        				<td>{{$item->qtd}}</td>
        				<td>{{$item->product->unidade}}</td>
        				<td>{{number_format($item->preco, 2)}}</td>
        				<td>{{number_format($item->preco * $item->qtd, 2)}}</td>
        			</tr>        			
        		@endforeach
            	</tbody>
        	</table>
        
        
        <div class="form-group">
            <label for="nome">Total</label>
            <input class="form-control" value="R$ {{ number_format($pedido->total, 2) }}" readonly>
        </div>
        
        </div>

        <div>
        	<h3>Pagamentos</h3>
        	<table class='table'>
            	<thead>
                	<tr>
                		<th>Data</th>
                		<th>Tipo</th>
                		<th>Valor</th>
                	</tr>
            	</thead>
            	<tbody>            	
        		@forelse($pedido->pagamentos as $item)
        			<tr>
        				<td>{{ date_format($item->created_at, 'd/m/Y H:i') }}</td>
        				<td>{{$formasPagamento[$item->tipo]}}</td>
        				<td>{{number_format($item->valor, 2)}}</td>
        			</tr>        			
        		@endforeach
            	</tbody>
        	</table>
        </div>
            
      	<div class="form-group">
  			<a class="btn btn-primary" href="{{route('admin.pedidos.index')}}">Voltar</a>
 		</div>
 		
	</form>
	
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/products_edit.js')}}"></script>
@endpush
