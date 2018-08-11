<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-pesquisar-produto">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Pesquisar produto</div>
            </div>
            <div class="modal-body">
        		<div class="col-sm-6">
                    <form name='form_pesquisar' >
                    	<div class="form-inline">
                    		<label for="pesquisar_cod_barra">Código de barra</label>
                        	<input type="text" class="form-control numIntPositivo" id="pesquisar_cod_barra" name="pesquisar_cod_barra" value="" autocomplete="on" maxlength="13" >
                    	</div>
                    	
                    	<div class="form-inline">
                    		<label for="pesquisar_nome">Nome</label>
                        	<input type="text" class="form-control" id="pesquisar_nome" name="pesquisar_nome" value="" autocomplete="on" maxlength="80" >
                    	</div>
    
                    	<div class="form-inline">
                    		<label for="pesquisar_marca">Marca/Fabricante</label>
                        	<input type="text" class="form-control" id="pesquisar_marca" name="pesquisar_marca" value="" autocomplete="on" maxlength="80" >
                    	</div>
                    	
                        <div class="form-group">
                            <label for="pesquisar_categoria">Categoria</label>
                            <select id='pesquisar_categoria' name='pesquisar_categoria' class="form-control">
                            	<option value=''>Todas</option>
                            	@foreach($categorias as $categoria)
                            	<option value="{{$categoria->id}}">{{$categoria->name}}</option>
                            	@endforeach
                            </select>
                        </div>
                    	<button type="submit" class="btn btn-primary" id="bt-confirmar-pesquisar">
                    		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                    	Pesquisar</button>
                	</form>
                	
                	<h4>Produtos</h4>
                    <div id ="divItensPesquisa" class='itensPedido pre-scrollable'>                    	
                    	<table class="table table-stripped">
                    		<thead>
                    			<tr>
                    				<th>n°</th>
                    				<th>Produto</th>
                    				<th>Unid.</th>
                    				<th>Val. Unit.</th>
                    			</tr>
                    		</thead>
                    		<tbody id='itensPesquisa'>
                    		</tbody>
                    	</table>
                    </div>
                </div>
                
        		<div class="col-sm-6 result">
            		<figure>
                    	<img id='pesquisar_imagemProduto' class='img-responsive img-result' src=''>
    					<figcaption id="pesquisar_imagemProdutoCaption"></figcaption>
    				</figure>
                    <div class="row">
                    <h2 id="divMsgPesquisa" class="text-center"></h2>
                        <div class='form-inline'>
			            	<form id='pesquisarAdd'>
                            	<label for="txtPesquisaAddQtd">Qtd.</label>
                            	<input type='text' id='txtPesquisaAddQtd' class='form-control numPositivo'  maxlength="6" size='10' autocomplete="off">
                                 <button type='submit' id='btPesquisaAddProduto' class='btn btn-primary'>Adicionar</button>
            			     </form>
                        </div>
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
        <script src = "{{asset('js/admin/modal_pedido_pesquisar_produto.js')}}"></script>
    @endpush
