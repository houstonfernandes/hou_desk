@extends('layouts.app')

@section('content')

    <h2 class='title'>Novo Tipo de serviço</h2>
    
    <form method="post" action="{{route('admin.tipos_servico.store')}}" name='form' >
    {{ csrf_field() }}
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" placeholder="nome do tipo" maxlength="80" required>
      </div>
      
      <div class="form-inline">
        <label for="nome">Duração</label>
        <input type="text" class="form-control numPositivo" id="duracao" name="duracao" value="{{old('duracao')}}" placeholder="" maxlength="2" required>
        <div class="checkbox">
        	<label>
          		<input type="radio" name='duracao_unidade' value='m' checked>minutos
        	</label>
        	<label>
          		<input type="radio" name='duracao_unidade' value='h'>horas
        	</label>
        	<label>
          		<input type="radio" name='duracao_unidade' value='d'>dias
        	</label>    	
      	</div>        
      </div>

	
	
    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.tipos_servico.index')}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/tipos_servico_create.js')}}"></script>
@endpush