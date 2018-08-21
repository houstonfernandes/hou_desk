@extends('layouts.app')

@section('content')
    <h2 class='title'>Editar Tipo de equipamento - {{$tipoEquipamento->nome}}</h2>
    
    <form method="post" action="{{route('admin.tipos_equipamento.update', $tipoEquipamento->id)}}" name='form' >
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
      <input type="hidden" name='id' value='{{$tipoEquipamento->id}}'>
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{$tipoEquipamento->nome}}" placeholder="nome do tipo" maxlength="80" required>
      </div>
      
      <div class="form-group">
		<label for="descricao">Descrição</label>
		<textarea class="form-control" rows='3' name='descricao'>{{$tipoEquipamento->descricao}}</textarea>        
	</div>
		
	<div class="checkbox">
    	<label>
    		<input type="hidden" name="ativo" value="0"><!-- para desativar se estiver desmarcado -->
    		<input type="checkbox" name="ativo" value="1" {{$tipoEquipamento->ativo==1 ? "checked ":""}}>
    		Ativo
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
    <script src="{{asset('js/admin/tipos_equipamento_create.js')}}"></script>
@endpush