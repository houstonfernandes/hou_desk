<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-pagamento">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Pagamento</div>
            </div>
            
            <div class="modal-body">
                <div class="jumbotron text-center" id="pagamentoDestaque"></div>
                    
                <form id='formPagamento' >
                    <div class="form-group">
                        <label for="pagamento_forma">Forma de Pagamento</label>
                        <select id='pagamento_forma' class="form-control">
                        	@foreach($formasPagamento as $id=>$value)
                        	<option value="{{$id}}" {{$id=='0'?'selected':''}}>{{$value}}</option>
                        	@endforeach
                        </select>
                    </div>                    
                	<div class="form-inline">
                		<label for="pagamento_valor">Valor</label>
                    	<input type="text" class="form-control numPositivo" id="pagamento_valor" name="pagamento_valor" value="" autocomplete="off" maxlength="13">
					    <button type="submit" class="btn btn-primary" id='btPagamentoAdd' title='Adicionar Pagamento'>Adicionar</button>            
                	</div>
            	</form>
                	
              	<h3>Pagamentos</h3>
                <div id ="divItensPagamento" class='itensPedido pre-scrollable'>
                	<table class="table table-stripped">
                		<thead>
                			<tr>
                				<th>n°</th>
                				<th>Forma de pagamento</th>
                				<th>Valor</th>
                			</tr>
                		</thead>
                		<tbody id='itensPagamento'>
                		</tbody>
                	</table>
                </div>
            </div>
                
            <div class="modal-footer">
            	<form id='pagamentoFinalizar'>
                	<button type="submit" class="btn btn-primary" id="btConfirmarPagamento">Confirmar</button>
                	<button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_pedido_pagamento.js')}}"></script>
    @endpush
