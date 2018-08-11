<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalPesquisarFornecedor">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Pesquisar Fornecedor</div>
            </div>
            <div class="modal-body">
                <form name='formPesquisarFornecedor'>
                	<div class="form-inline">
                		<label for="txtPesquisarFornecedorNome">Nome</label>
                    	<input type="text" class="form-control" id="txtPesquisarFornecedorNome" name="txtPesquisarFornecedorNome" value="" autocomplete="on" maxlength="80" >
                	</div>
                	
                	<div class="form-inline">
                		<label for="txtPesquisarFornecedorNomeFantasia">Nome fantasia</label>
                    	<input type="text" class="form-control" id="txtPesquisarFornecedorNomeFantasia" name="txtPesquisarFornecedorNomeFantasia" value="" autocomplete="on" maxlength="80" >
                	</div>

                	<div class="form-inline">
                		<label for="txtPesquisarFornecedorEndereco">Endereco</label>
                    	<input type="text" class="form-control" id="txtPesquisarFornecedorEndereco" name="txtPesquisarFornecedorEndereco" value="" autocomplete="on" maxlength="80" >
                	</div>
                	
                	<div class="form-inline">
                		<label for="txtPesquisarFornecedorCidade">Cidade</label>
                    	<input type="text" class="form-control" id="txtPesquisarFornecedorCidade" name="txtPesquisarFornecedorCidade" value="" autocomplete="on" maxlength="80" >
                	</div>
                	
                	<div class="form-inline">
                		<label for="txtPesquisarFornecedorEmail">Email</label>
                    	<input type="text" class="form-control" id="txtPesquisarFornecedorEmail" name="txtPesquisarFornecedorEmail" value="" autocomplete="on" maxlength="80" >
                	</div>
                	
                	<button type="submit" class="btn btn-primary">
                		<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
                	Pesquisar</button>
            	</form>
            	
            	<h4>Fornecedores</h4>
                <div id ="divItensPesquisaFornecedores" class='itensPedido pre-scrollable'>                    	
                	<table class="table table-stripped">
                		<thead>
                			<tr>
                				<th>N.</th>
                				<th>Nome</th>
                				<th>N. Fantasia</th>
                				<th>email</th>
                				<th>Tel.</th>
                				<th>Cel.</th>
                			</tr>
                		</thead>
                		<tbody id='tbPesquisarFornecedorItens'>
                		</tbody>
                	</table>
                </div>
                <div class="form-control">
                <form id='formPesquisaFornecedorSelecionar'>
                	<label for="txtPesquisarFornecedorSelecionado">Fornecedor</label>
                	<input type="text" class="form-control" id="txtPesquisarFornecedorSelecionado" readonly >
                </form>
                </div>
                <div id="divPesquisarFornecedorMsg"></div>
            </div>
            <div class="modal-footer">
                <button type='submit' class='btn btn-primary' form="formPesquisaFornecedorSelecionar">Selecionar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Fechar</button>
            </div>
		</div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_compra_pesquisar_fornecedor.js')}}"></script>
    @endpush
