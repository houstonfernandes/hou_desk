<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalCompraPesquisarProduto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Pesquisar produto</div>
            </div>
            <div class="modal-body">
        		<div class="col-sm-6">
                    <form id="formProdutoPesquisar">
                    	<div class="form-inline">
                    		<label for="txtCompraProdutoPesquisaCodBarra">Código de barra</label>
                        	<input type="text" class="form-control numIntPositivo" id="txtCompraProdutoPesquisaCodBarra" name="txtCompraProdutoPesquisaCodBarra" value="" autocomplete="on" maxlength="13" >
                    	</div>
                    	
                    	<div class="form-inline">
                    		<label for="txtCompraProdutoPesquisaNome">Nome</label>
                        	<input type="text" class="form-control" id="txtCompraProdutoPesquisaNome" name="txtCompraProdutoPesquisaNome" value="" autocomplete="on" maxlength="80" >
                    	</div>
    
                    	<div class="form-inline">
                    		<label for="txtCompraProdutoPesquisaMarca">Marca/Fabricante</label>
                        	<input type="text" class="form-control" id="txtCompraProdutoPesquisaMarca" name="txtCompraProdutoPesquisaMarca" value="" autocomplete="on" maxlength="80" >
                    	</div>
                    	
                        <div class="form-group">
                            <label for="txtCompraProdutoPesquisaCategoria">Categoria</label>
                            <select id='txtCompraProdutoPesquisaCategoria' name='txtCompraProdutoPesquisaCategoria' class="form-control">
                            	<option value=''>Todas</option>
                            	@foreach($categorias as $categoria)
                            	<option value="{{$categoria->id}}">{{$categoria->name}}</option>
                            	@endforeach
                            </select>
                        </div>
                    	<button type="submit" class="btn btn-primary" id="btCompraProdutoPesquisaConfirmar">
                    		Pesquisar
                    		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    	</button>
                	</form>
                	
                	<h4>Produtos</h4>
                    <div id ="divCompraProdutoItensPesquisa" class='itensPedido pre-scrollable'>                    	
                    	<table class="table table-stripped">
                    		<thead>
                    			<tr>
                    				<th>n°</th>
                    				<th>Produto</th>
                    				<th>Unid.</th>
                    				<th>Val. Unit.</th>
                    			</tr>
                    		</thead>
                    		<tbody id='tbCompraProdutoItensPesquisa'></tbody>
                    	</table>
                    </div>
                </div>
                
        		<div class="col-sm-6 result">
                    <div class="row">
                    	<div id="divCompraProdutoPesquisaMsg" class="text-center success"></div>                    
                        <div class="panel panel-primary">
                          <div class="panel-heading">
                            <h3 class="panel-title">Produto</h3>
                          </div>
                          <div class="panel-body">
                    		<figure>
                            	<img id='imgCompraProdutoPesquisaImagem' class='img-responsive img-result' src=''>
            					<figcaption id="imgCompraProdutoPesquisaImagemCaption"></figcaption>
            				</figure>
            				<div id='divCompraProdutoPesquisaDados'></div>                            
                          </div>
                        </div>
		            	<form id='formProdutoPesquisarAdd'>
                        <div class='form-inline'>
                        	<label for="txtCompraProdutoPesquisaAddQtd">Qtd.</label>
                        	<input type='text' id='txtCompraProdutoPesquisaAddQtd' class='form-control numPositivo'  maxlength="6" size='10' autocomplete="off">
                        </div>
                        <div class='form-inline'>
                        	<label for="txtCompraProdutoPesquisaAddValor">Valor</label>
                        	<input type='text' id='txtCompraProdutoPesquisaAddValor' class='form-control numPositivo'  maxlength="6" size='10' autocomplete="off">
                        </div>
                        <div class='form-inline'>
							<label for="txtCompraProdutoPesquisaAddDesconto">Desconto</label>
                        	<input type='text' id='txtCompraProdutoPesquisaAddDesconto' class='form-control numPositivo'  maxlength="6" size='10' autocomplete="off">                           	
                        </div>
                             <button type='submit' id='btCompraProdutoPesquisaAddConfirmar' class='btn btn-success'>
                             	Adicionar
                             	<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                             </button>
        			     </form>
                        
                        
                    </div>    
        		</div>
            </div>
            <div class="modal-footer">
                
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
        </div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_compra_pesquisar_produto.js')}}"></script>
    @endpush
