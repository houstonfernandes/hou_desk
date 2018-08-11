<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalCompraEditarItem">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Editar item</div>
            </div>
            <div class="modal-body">
            
        		<div class="col-sm-6">
                    <form id="formCompraItem">
                    	<div class="form-inline">
                    		<label for="txtCompraEditarItemCodBarra">Código de barra</label>
                        	<input type="text" class="form-control numIntPositivo" id="txtCompraEditarItemCodBarra" value="" readonly maxlength="13" >
                    	</div>
                    	
                    	<div class="form-inline">
                    		<label for="txtCompraEditarItemNome">Nome</label>
                        	<input type="text" class="form-control" id="txtCompraEditarItemNome" value="" readonly maxlength="80" >
                    	</div>
    
                    	<div class="form-inline">
                    		<label for="txtCompraEditarItemQtd">Qtd.</label>
                        	<input type="text" class="form-control" id="txtCompraEditarItemQtd" value="" readonly maxlength="10" >
                        	<label for="txtCompraEditarItemUnidade">Unidade</label>
                        	<input type="text" class="form-control" id="txtCompraEditarItemUnidade" value="" readonly maxlength="10" >
                    	</div>                    	                    	
                	</form>                	                	                	
                </div>
                                
        		<div class="col-sm-6 result">
                    <div class="row">
                		<figure>
                        	<img id='imgCompraProdutoPesquisaImagem' class='img-responsive img-result' src=''>
        					<figcaption id="imgCompraProdutoPesquisaImagemCaption"></figcaption>
        				</figure>
                    </div>    
        		</div>
            
                <div class="col-sm-12">
                    	<form id="formCompraItemEditar">                    		
                            <div class='form-inline'>
                            	<label for="txtCompraEditarItemQtdEntregue">Qtd. entregue</label>
    	                       	<input type="text" class="form-control numPositivo" id="txtCompraEditarItemQtdEntregue" value="" maxlength="10" >
                            </div>
                            <div class='form-inline'>
                        		<label for="txtCompraEditarItemPreco">Preço unit.</label>
                            	<input type="text" class="form-control numPositivo" id="txtCompraEditarItemPreco" value="" maxlength="6" size='10' autocomplete="off">                        
                            </div>
                            <div class='form-inline'>
                            	<label for="txtCompraEditarItemDesconto">Desconto unit.</label>
                            	<input type="text" class="form-control numPositivo" id="txtCompraEditarItemDesconto" value="" maxlength="6" size='10' autocomplete="off">                        	
                            </div>
                            
                            <div class='form-group'>
                            	<label for="txtCompraEditarItemObs">Obs.</label>
                            	<textarea class="form-control" id="txtCompraEditarItemObs" rows="3"></textarea>
                            </div>
                            <div class='form-group'>
                            	<button type="submit" class="btn btn-success">
                        		Confirmar
                        		<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>
                        		</button>
                        	</div>                        
            			  </form>                
                </div>
            </div>
            <div class="modal-footer">                
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_compra_editar_item.js')}}"></script>
    @endpush
