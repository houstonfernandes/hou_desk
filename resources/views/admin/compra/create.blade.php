@extends('layouts.app')

@section('content')


{{--    <h2 class='title'>COMPRAS</h2>--}}
            <div class="jumbotron">
                <h1 id="destaque" class="text-center">COMPRAS</span></h1>
                <h2 class="text-center" id='produto'><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> {{config('app.name')}} </h2>                                
            </div>    
    <div class="row">
        <div class="col-sm-6">
        	<form id='form_compra'>        	
        	<input type="hidden" class="form-control" id='imagemProduto' src='/imagens/logo_garafas.jpg'>        		
              <input type="hidden" class="form-control" id="user_id" name="user_id" value="{{$user->id}}">                
            <div class="form-group">
              <label for="nome">Usuário</label>
              <input type="text" class="form-control" id="user_name" value="{{$user->id .' - ' .$user->name}}" readonly>
            </div>
            
            <div class="form-inline">
              <label for="nome">Fornecedor</label>
              <input type="hidden" id="fornecedor_id">
              <input type="text" class="form-control" id="txtFornecedorNome" readonly >
{{--                <select id='fornecedor_id' name='fornecedor_id' class="form-control">
                	@foreach($fornecedores as $fornecedor)
                	<option value="{{$fornecedor->id}}" {{$fornecedor->id=='1'?'selected':''}}>{{$fornecedor->nome}}</option>
                	@endforeach
                </select>
                --}}
                <button type="button" class="btn btn-primary" id='btPesquisarFornecedor' title='Pesquisar Fornecedor' data-toggle="modal" data-target="#modalPesquisarFornecedor" data-url="{{route('api.fornecedores.search')}}">
                    <span class="glyphicon glyphicon-search" aria-hidden="true"></span>                
                </button>
            </div>            
        	
        	<div class="form-inline">
        		<label for="frete">Frete</label>
                <input type="text" class="form-control moeda" id="frete" name="frete" value="" maxlength="6" size="10" autocomplete="off">
            </div>
            <div class="form-inline">
        		<label for="imposto">imposto</label>
                <input type="text" class="form-control moeda" id="imposto" name="imposto" value="" maxlength="6" size="10" autocomplete="off">
            </div>
            
            <div class="form-inline">
        		<label for="nf">N.F.</label>
                <input type="text" class="form-control numIntPositivo" id="nf" name="nf" value="" maxlength="6" size="10" autocomplete="off">
            </div>

            <div class="form-group">
        		<label for="obs">Obs.</label>
                <textarea id="obs" class="form-control" name="obs" rows="3"></textarea>
            </div>
          	                
            <div class="form-group">
                <label for="status">Tipo de Compra</label>
                <select id='status' name='status' class="form-control">
                	@foreach($statusCompras as $id=>$value)
                	<option value="{{$id}}" {{$id=='1'?'selected':''}}>{{$value}}</option>
                	@endforeach
                </select>
            </div>
            
          	<div class="form-group">
{{--      			<button type="submit" class="btn btn-primary">Confirmar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button>--}}
     		</div>
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
            				<th>Desc. Unit.</th>
            				<th>Val.Total</th>
            			</tr>
            		</thead>
            		<tbody id='itensPedido'>
            		</tbody>
            	</table>
            </div>
            
			<div class="form-inline">
			<button type="button" class="btn btn-primary" id='btPesquisarProduto' title='Pesquisar produtos' data-toggle="modal" data-target="#modalCompraPesquisarProduto" data-url="{{route('api.products.search')}}">
				Adicionar itens
				<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
			</button>
	       		<button type="button" class="btn btn-danger" id='btExcluirItem' title="Excluir item" data-toggle="modal" data-target="#modalCompraExcluirItem" data-url="">
	       			Excluir Item
	       			<span class="glyphicon glyphicon-minus" aria-hidden="true"></span>
	       		</button>
              	<button class="btn btn-success" id='btFinalizarCompra' title='Finalizar Compra'>
              		Finalizar Compra <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
              	</button>
              	<a class="btn btn-primary" href="{{route('admin.compras.index')}}" title="Voltar para compras">      			
	      			Compras <span class="glyphicon glyphicon-level-up" aria-hidden="true"></span>
      			</a>
              	                
            </div>
           
              
        </div>
    </div>
@include('partial.modal_compra_pesquisar_produto')
@include('partial.modal_compra_pesquisar_fornecedor')  
@include('partial.modal_compra_excluir_item')    
{{--@include('partial.modal_pedido_pagamento')--}}


@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/compra_create_init.js')}}"></script>
@endpush

@push('css')
    <style>
        body{          /*#D2E5A9;*/
            background-color: #B7BEC8;
            
        }
        .container, .modal-content{
          /*      background-color: #FFF06B;/*FFE81A;*/
        
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