@extends('layouts.app')

@section('content')


    <h2 class='title'>Receber Compra</h2>
{{--            <div class="jumbotron">
                <h1 id="destaque" class="text-center">COMPRAS</span></h1>
                <h2 class="text-center" id='produto'><span class="glyphicon glyphicon-shopping-cart" aria-hidden="true"> {{config('app.name')}} </h2>                                
            </div>    
   --}} 
    <div class="row">
    	<form id='form_compra'>
    		<input type="hidden" id='id' value="{{$compra->id}}">
        <div class="form-group">
          <label for="data_compra">Data</label>
          <input type="text" class="form-control" id="data_compra" value="{{date_format($compra->created_at, 'd/m/Y H:i')}}" readonly>
        </div>
        
        <div class="form-group">
          <label for="nome">Usuário:</label>
          <input type="text" class="form-control" id="user_name" value="{{$compra->user->name}}" readonly>
        </div>
        
        <div class="form-group">
          <label for="fornecedor_nome">Fornecedor</label>
          <input type="text" class="form-control" id="fornecedor_nome" value="{{$compra->fornecedor->nome}}" readonly>
        </div>
        
        <div class="form-inline">
    		<label for="nf">N.F.</label>
            <input type="text" class="form-control numIntPositivo" id="nf" name="nf" value="{{$compra->nf}}" maxlength="6" size="10" autocomplete="off">
        </div>

        <div class="form-group">
    		<label for="obs">Obs.</label>
            <textarea id="obs" class="form-control" name="obs" rows="3">{{$compra->obs}}</textarea>
        </div>
        
      	<div class="form-group">
{{--  			<button type="submit" class="btn btn-primary">Confirmar <span class="glyphicon glyphicon-ok" aria-hidden="true"></span> </button>--}}
 		</div>
	</form>
         
    </div>
    <div class="row">
    	<h3>itens</h3>
        <div id ="divItensPedido" class='itensPedido'>        	
        	<table class="table table-stripped">
        		<thead>
        			<tr>
        				<th>n°</th>
        				<th>Produto</th>
        				<th>Qtd. ped.</th>
        				<th>Qtd. ent.</th>
        				<th>Unid.</th>
        				<th>Val. Unit.</th>
        				<th>Desc. Unit.</th>
        				<th>Val.Total</th>
        				<th>Funções</th>
        			</tr>
        		</thead>
        		<tbody id='itensPedido' data-itens = "{{ $itens }}"></tbody>
        	</table>
        </div>
        <div>
        	<div class="form-inline">
        		<label for="frete">Frete R$</label> 
                <input type="text" class="form-control moeda" id="frete" value="{{number_format($compra->frete, 2)}}" maxlength="6" size="10" autocomplete="off">
        		<label for="imposto">Imposto R$</label>
                <input type="text" class="form-control moeda" id="imposto" value="{{number_format($compra->imposto, 2)}}" maxlength="6" size="10" autocomplete="off">
            </div>

            <div class="form-group">
        		<label for="total">Total compra R$</label>
                <input type="text" class="form-control moeda numero" id="txtCompraTotal" value="{{number_format($compra->total, 2)}}" maxlength="6" size="10" readonly>
            </div>
        
        </div>
        
		<div class="form-inline">
          	<button class="btn btn-success" id='btFinalizarCompra' title='Finalizar Compra'>
          		Finalizar Compra <span class="glyphicon glyphicon-save" aria-hidden="true"></span>
          	</button>
          	<a class="btn btn-primary" href="{{route('admin.compras.index')}}" title="Voltar para compras">      			
      			Compras <span class="glyphicon glyphicon-level-up" aria-hidden="true"></span>
  			</a>
          	                
        </div>       
          
    </div>
    
@include('partial.modal_compra_editar_item')    

@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/compra_edit_init.js')}}"></script>
@endpush

@push('css')

    <style>
        body{          /*#D2E5A9;*/
            background-color: #B7BEC8;
            
        }
        .container, .modal-content{
          /*      background-color: #FFF06B;/*FFE81A;*/
        
        }
        {{--
        form input[type=text], select option, textarea{
            font-size: 24pt;
            margin-bottom: 3px;
            margin-top: 3px;
        }
        --}}
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