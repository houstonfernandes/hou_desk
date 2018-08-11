@extends('layouts.app')

@section('content')


    <h2 class='title'>Receber Compra</h2>

    

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
 		</div>
	</form>
         
    </div>
    <div class="row">
    	<h3>itens</h3>
    
    @verbatim
    <div id="app"><h1>VUE</h1>
        <!-- os dados de v-model devem ser declarados em data, mesmo que vazios -->
        <input v-model="message" placeholder="edit me">
        {{ message }}            
        <p>Message is: {{ message }}</p>
        <input v-model.number="age" type="number">
        
            <ul>
              	<li v-for="item in items">
                {{ item.product.nome }}
              </li>
            </ul>
        <div id ="divItensPedido2" class='itensPedido'>        	
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
        			</tr>
        		</thead>
        		<tbody id='itensPedido2'>
                  	<tr v-for="item in items">
                  		<td></td>
                  		<td>{{ item.product.nome }}</td>
                  		<td>{{ item.qtd }}</td>
                  		<td><input v-model="item.qtd_entregue"></td>
                  		<td>{{ item.product.unidade }}</td>
                  		<td><input class="table" v-model="item.preco"></td>
                  		<td><input class="table" v-model="item.desconto"></td>
                  		<td>{{ calcularTotal(item) }}</td>
                  </tr>			
		        			
        			
        		</tbody>
        	</table>
        </div>
            <div class="form-group">
        		<label for="total">Total compra R$</label>
                <input type="text" class="form-control moeda numero" value="" maxlength="6" size="10" readonly>
            </div>
        
    </div>
@endverbatim
        	
    	
    	
    	
    	
    	
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
    
    <script
  src="https://code.jquery.com/jquery-3.3.1.min.js"
  integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8="
  crossorigin="anonymous"></script>
 
    
    <script>
    	var app = new Vue({
        el: '#app',
        data: {
            message: 'Hello Vue!',
            teste:'',
            texto:'teste de dfdteedf teste',
            age:'',
            items:[]
                
        },
        methods:{
        	calcularTotal :function(item){
            	
            	var total = (parseFloat(item.preco) - parseFloat(item.desconto)) * item.qtd_entregue;
            	console.log(total);
				return total; 
                },

            calcularTotalCompra :function(){
                	var total;
                	for (i in this.items){
						total += calcularTotal(this.items[i]);
                    }
    				return total; 
            }
        },      
        mounted: function () {
            var self = this;
            self.items = $("#itensPedido").data('itens');
            console.log('listar itens');
            //console.log($("#itensPedido").data('itens'));
            $.each(self.items, function( i, item) {
            	console.log(item.product.nome);	
            	}
        	);
                    
            /*
            $.ajax({
                url: '/items',
                method: 'GET',
                success: function (data) {
                    self.items = data;
                },
                error: function (error) {
                    console.log(error);
                }
            });
            */
        }
        
        
        });
	

    </script>
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