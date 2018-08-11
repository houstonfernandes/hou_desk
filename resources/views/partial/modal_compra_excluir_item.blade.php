<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modalCompraExcluirItem">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Excluir item de compra</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="selCompraExcluirItem">Itens</label>
                    <select id='selCompraExcluirItem' form='formCompraExcluirItem' class="form-control" size='10'></select>
                </div>
            </div>
            <div class="modal-footer">
                <form id = 'formCompraExcluirItem'>
                    <button type="submit" class="btn btn-primary">Confirmar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_compra_excluir_item.js')}}"></script>
    @endpush
