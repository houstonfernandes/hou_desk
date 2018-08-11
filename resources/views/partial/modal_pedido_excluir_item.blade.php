<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-excluir-item">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Excluir item de Pedido</div>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <label for="itemExcluir">Itens</label>
                    <select id='itemExcluir' form='formExcluir' class="form-control" size='10'></select>
                </div>
            </div>
            <div class="modal-footer">
                <form id = 'formExcluir'>
                    <button type="submit" class="btn btn-primary" id="btConfirmarExcluir">Confirmar</button>
                    <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                </form>
            </div>
        </div>
	</div>
</div>

    @push('js')
        <script src = "{{asset('js/admin/modal_pedido_excluir_item.js')}}"></script>
    @endpush
