@extends('layouts.app')

@section('content')

    <h2 class='title'>Nova solicitação de serviço</h2>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Local: {{$local->nome}}</li>
        	@if($local->tecnico)
        	<li class="list-group-item ">Técnico: {{$local->tecnico->name}}	</li>        	
             @else
             <li class="list-group-item "><span class='text-warning'>Definir o técnico no cadastro do local. </span></li>
        	@endif
        </ul>
    </div>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Solicitante: {{Auth::user()->name}}</li>
        </ul>
    </div>

    <form method="post" action="{{route('servicos.store')}}" name='form'>
    {{ csrf_field() }}
      <input type="hidden" name='local_id' value='{{$local->id}}'>

    	<div class="form-group">
    	    <label for="setor_id">Setor</label>
            <select id='setor_id' name='setor_id' class="form-control" required>
            	<option value=''>Selecione uma opção</option>
            	@foreach($local->setores as $setor)            	
            	<option value="{{$setor->id}}" {{$setor->id==old('setor_id')?'selected':''}}>{{$setor->nome}}</option>
            	@endforeach
            </select>
        </div>
        
    	<div class="form-group">
    	    <label for="setor_id">Equipamento</label>
            <select id='equipamento_id' name='equipamento_id' class="form-control" required> </select>
        </div>

    	<div class="form-group">
    	    <label for="tipo_servico_id">Tipo de serviço</label>
            <select id=='tipo_servico_id' name='tipo_servico_id' class="form-control" required>
            	<option value=''>Selecione uma opção</option>
            	@foreach($tiposServico as $tipoServico)            	
            	<option value="{{$tipoServico->id}}" {{$tipoServico->id==old('tipo_servico_id')?'selected':''}}>{{$tipoServico->nome}}</option>
            	@endforeach
            </select>
        </div>

		<div class="form-group">
    		<label for="descricao">Descrição do problema</label>
    		<textarea class="form-control" rows='3' name='descricao'>{{old('descricao')}}</textarea>        
		</div>
		
		<div class="form-group">
      		@if($local->tecnico)
      			<label>
        	     	<input type="checkbox" name="notificar_tecnico" value="1"> Notificar técnico
        	    </label>
        	@endif
        </div>
	
        <div class="form-group">
      		<button type="submit" class="btn btn-primary">Confirmar</button>
      		<a class="btn btn-primary" href="{{route('servicos.index', $local->id)}}">Cancelar</a>
      		
    	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_ui.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    
    <script src="{{asset('js/servicos_create.js')}}"></script>
@endpush

@push('css')
	<link rel='stylesheet' media='all' href="{{asset('css/jquery-ui.min.css')}}" type='text/css' />
@endpush
