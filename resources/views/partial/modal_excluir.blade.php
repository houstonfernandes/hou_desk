<div class="modal fade" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel" id="modal-excluir">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
            	<div class="modal-title">Confirme</div>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="bt-confirmar-excluir">Confirmar</button>
                <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
            </div>
        </div>
	</div>
</div>

<form name = 'form-modal-excluir' method="post" hidden>
	{{csrf_field()}}
	<input type="hidden" name="_method" value='delete'>
</form>

@push('js')
    <script src = "{{asset('js/admin/modal_excluir.js')}}"></script>
@endpush

