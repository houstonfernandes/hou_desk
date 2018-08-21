@extends('layouts.app')

@section('content')

    <h2 class='title'>Novo Tipo de equipamento</h2>
    
    <form method="post" action="{{route('admin.tipos_equipamento.store')}}" name='form' >
    {{ csrf_field() }}
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" placeholder="nome do tipo" maxlength="80" required>
      </div>

	<div class="form-group">
		<label for="descricao">Descrição</label>
		<textarea class="form-control" rows='3' name='descricao'>{{old('descricao')}}</textarea>        
	</div>
	
	<div class="checkbox">
    	<label>
    		<input type="hidden" name="ativo" value="0"><!-- para desativar se estiver desmarcado -->
      		<input type="checkbox" name='ativo' value='1' checked>Ativo
    	</label>
  	</div>
	
    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.tipos_equipamento.index')}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/tipos_equipamento_create.js')}}"></script>
@endpush