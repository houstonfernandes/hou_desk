@extends('layouts.app')

@section('content')
    <h2 class='title'>Editar Tipo de serviço - {{$tipoServico->nome}}</h2>
    
    <form method="post" action="{{route('admin.tipos_servico.update', $tipoServico->id)}}" name='form' >
    <input type="hidden" name="_method" value="put">
    {{ csrf_field() }}
      <input type="hidden" name='id' value='{{$tipoServico->id}}'>
      
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{$tipoServico->nome}}" placeholder="nome do tipo" maxlength="80" required>
      </div>
      
      <div class="form-inline">
        <label for="nome">Duração</label>
        <input type="text" class="form-control numPositivo" id="duracao" name="duracao" value="{{$tipoServico->duracao}}" placeholder="" maxlength="2" required>
        <div class="checkbox">
        	<label>
          		<input type="radio" name='duracao_unidade' value='m' {{($tipoServico->duracao_unidade == 'm')? 'checked' : ''}} >minutos
        	</label>
        	<label>
          		<input type="radio" name='duracao_unidade' value='h' {{($tipoServico->duracao_unidade == 'h')? 'checked' : ''}} >horas
        	</label>
        	<label>
          		<input type="radio" name='duracao_unidade' value='d' {{($tipoServico->duracao_unidade == 'd')? 'checked' : ''}} >dias
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
    <script src="{{asset('js/admin/tipos_servico_edit.js')}}"></script>
@endpush