@extends('layouts.app')

@section('content')

    <h2 class='title'>Consultar compra</h2>    
    
        <div class="form-inline">
            <label for="nome">Número</label>
            <input class="form-control" value="{{$pedido->id}}" readonly>        
            <label for="nome">Data</label>
            <input class="form-control" value="{{ date_format($pedido->created_at, 'd/m/Y H:i') }}" readonly>
            <label for="nome">Data chegada</label>
            <input class="form-control" value="{{($pedido->data_chegada)?date_format(date_create($pedido->data_chegada), 'd/m/Y H:i'):''}}" readonly>
            <label for="nome">Status</label>
            <input class="form-control" value="{{$statusCompras[$pedido->status]}}" readonly>

        </div>

	<form action="#" name="form">
    	<div class="form-group">
            <label for="nome">NF.</label>
            <input class="form-control" value="{{$pedido->nf}}" readonly>        
    	</div>
	
    	<div class="form-group">
            <label for="name">Fornecedor</label>
            <input class="form-control" value="{{ $pedido->fornecedor->nome}}" readonly>
		</div>
            
        <div class="form-group">
            <label for="cod_barra">Comprador</label>
            <input class="form-control" value="{{ $pedido->user->name}}" readonly>
        </div>
        
        <div class="form-group">
            <label for="cod_barra">Obs.</label>
            <textarea class="form-control" readonly>{{$pedido->obs}}"</textarea>
        </div>
        
        <div>
        	<h3>Itens</h3>
        	<table class='table'>
            	<thead>
                	<tr>
                		<th>Produto</th>
                		<th>Quantidade</th>
                		<th>Qtd. Entregue</th>
                		<th>Unid.</th>
                		<th>Preço unit</th>
                		<th>Desconto</th>
                		<th>Preço total</th>
                	</tr>
            	</thead>
            	<tbody>            	
        		@foreach($pedido->items as $item)
        			<tr>
        				<td>{{$item->product->nome}}</td>
        				<td>{{$item->qtd}}</td>
        				<td>{{$item->qtd_entregue}}</td>
        				<td>{{$item->product->unidade}}</td>
        				<td>{{number_format($item->preco, 2)}}</td>
        				<td>{{number_format($item->desconto, 2)}}</td>
{{--calcular total pela qtd entregue se status = entregue--}}
						@if($pedido->status==0)
        					<td>{{number_format(($item->preco - $item->desconto) * $item->qtd_entregue, 2)}}</td>
        				@else
        					<td>{{number_format(($item->preco - $item->desconto) * $item->qtd, 2)}}</td>
                        @endif
        				
        			</tr>        			
        		@endforeach
            	</tbody>
        	</table>        	
        
        <div class="form-inline">
            <label>Frete</label>
            <input class="form-control" value="R$ {{ number_format($pedido->frete, 2) }}" readonly>
            <label>Imposto</label>
            <input class="form-control" value="R$ {{ number_format($pedido->imposto, 2) }}" readonly>
            
        </div>
        <div class="form-group">
            <label for="nome">Total</label>
            <input class="form-control" value="R$ {{ number_format($pedido->total, 2) }}" readonly>
        </div>
        
        </div>
{{--
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
    --}}        
      	<div class="form-group">
  			<a class="btn btn-primary" href="{{route('admin.compras.index')}}">Voltar</a>
 		</div>
 		
	</form>
	
@endsection

@push('js')

@endpush
