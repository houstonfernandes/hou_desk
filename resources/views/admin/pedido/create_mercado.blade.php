@extends('layouts.app')

@section('content')


{{--    <h2 class='title'>PDV</h2>--}}
            <div class="jumbotron">
                <h1 id="destaque" class="text-center">CAIXA LIVRE</span></h1>
                <h2 class="text-center" id='produto'><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> {{config('app.name')}} </h2>                                
            </div>    
    <div class="row">
        <div class="col-sm-6">        	
             <img id='imagemProduto' class='img-responsive img-pedido' src='/imagens/logo_garafas.jpg'>
              <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">                
{{--
            <div class="form-group">
              <label for="nome">Usuário</label>
              <input type="text" class="form-control" id="user_name" value="{{$user->id .' - ' .$user->name}}" readonly>
            </div>
--}}
        		<form id='formInserirProduto' >
        	<div class="form-inline">
        		<label for="cod_barra"> Código de barra</label>
            	<input type="text" class="form-control numIntPositivo" id="cod_barra" name="cod_barra" value="{{old('cod_barra')}}" autocomplete="on" maxlength="13">
        	</div>
        	
        	<div class="form-inline">
        		<label for="qtd">Qtd.</label>
                <input type="text" class="form-control numPositivo" id="qtd" name="qtd" value="1" maxlength="6" size="10" autocomplete="off">
				<label for="preco">Preço</label>
              	<input type="text" class="form-control moeda" id="preco" name="preco" value="" maxlength="5" size="10" autocomplete="off">
              	<input type="hidden" class="form-control" id="desconto" name="desconto" value="0" maxlength="6" size="10">
            </div>
        	<div class="form-inline">
              		<button type='submit' class="btn btn-primary" id="btInserir" title='inserir'>Inserir</button>
        	</div>
              	</form>                
                    	            
            <input type='hidden' id='status' value="1"><!--1 - venda entregue -->
            
{{--
            <div class="form-group">
                <label for="status">Tipo Pedido</label>
                <select id='status' name='status' class="form-control">
                	@foreach($statusPedidos as $id=>$value)
                	<option value="{{$id}}" {{$id=='1'?'selected':''}}>{{$value}}</option>
                	@endforeach
                </select>
            </div>
--}}           
            
		</form>
             
        </div>
        <div class="col-sm-6">
        	<h3>Items</h3>
            <div id ="divItensPedido" class='itensPedido pre-scrollable'>
            	
            	<table class="table table-stripped">
            		<thead>
            			<tr>
            			<th>n°</th>
            				<th>Produto</th>
            				<th>Qtd.</th>
            				<th>Unid.</th>
            				<th>Val. Unit.</th>
            				<th>Val.Total.</th>
            			</tr>
            		</thead>
            		<tbody id='itensPedido'>
            		</tbody>
            	</table>
            </div>
            
			<div class="form-inline">
			    <button type="button" class="btn btn-primary" id='btPesquisarProduto' title='Pesquisar produtos' data-toggle="modal" data-target="#modal-pesquisar-produto" data-url="{{route('api.products.search')}}">Pesquisar</button>               
	       		<button type="button" class="btn btn-danger" id='btExcluirItem' data-toggle="modal" data-target="#modal-excluir-item" data-url="{{route('api.users.get_permissions')}}" data-msg_alert="Autenticar gerente.">Excluir Item</button>
              	<button class="btn btn-success" id='btFinalizarCompra' title='Finalizar Compra'>Finalizar Compra</button>                
            </div>
           
            <div class="form-group">
              <label for="nome">Cliente</label>
              <input type="hidden" class="form-control" id="cliente_id" name="cliente_id" value="{{$cliente->id}}">                
              <input type="text" class="form-control" id="cliente_nome" value="{{$cliente->id .' - ' .$cliente->nome}}" readonly>
            </div>           
        </div>
    </div>        
    <div class="row">
        <div class="col-sm-6">
        </div>
    </div>    
  
@include('partial.modal_pedido_excluir_item')    
@include('partial.modal_pedido_pesquisar_produto')
@include('partial.modal_pedido_pagamento')

@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/pedido_create_mercado.js')}}"></script>
@endpush

@push('css')
    <style>
        body{          /*#D2E5A9;*/
            background-color: #B7BEC8;
            
        }
        .container, .modal-content{
                background-color: #FFF06B;/*FFE81A;*/
        
        }
        form input[type=text], select option{
            font-size: 24pt;
            border: 1px solid red;
            margin-bottom: 3px;
            margin-top: 3px;
        }
        .img-pedido{
            background-color: #ff0;
            border: 1px solid red;
            max-height: 400px;
            height: 400px;
        }
        .img-result{
            background-color: #fff;
            max-height: 400px;
            height: 400px;
        }
        
        .itensPedido{
            background-color: #ffb;
            color: black;
            font-size: 14pt;
            height:300px;
            border: 1px solid #000;
        }
        .jumbotron{
            color:red;
            background-color: #FFE81A;
            border: 1px solid red;
        }
        .result{
            background-color: #Fff;
            border: 1px solid red;
            color:red;
        }
        
    </style>
@endpush