@extends('layouts.app')

@section('content')

    <h2 class='title'>Novo Setor</h2>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Local: {{$local->nome}}</li>
        	<li class="list-group-item">CNPJ: {{$local->cnpj}}</li>
        	<li class="list-group-item">INEP: {{$local->inep}}</li>            	
        	<li class="list-group-item">email: {{$local->email}}</li>
        	<li class="list-group-item">Tel: {{$local->tel}}</li>
        	<li class="list-group-item">Cel: {{$local->cel}}</li>
        </ul>
    </div>

    <form method="post" action="{{route('admin.setores.store')}}" name='form' >
    {{ csrf_field() }}
      <input type="hidden" name='local_id' value='{{$local->id}}'>
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" placeholder="nome do setor" maxlength="100" required>
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
  		<a class="btn btn-primary" href="{{route('admin.setores.index', $local->id)}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/setores_create.js')}}"></script>
@endpush