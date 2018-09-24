@extends('layouts.app')

@section('content')

    <h2 class='title'>Consultar solicitação de serviço</h2>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Local: {{$servico->equipamento->setor->local->nome}}</li>
        	@if($servico->equipamento->setor->local->tecnico)
        	<li class="list-group-item ">Técnico: {{$servico->equipamento->setor->local->tecnico->name}}	</li>        	
             @else
             <li class="list-group-item "><span class='text-warning'>Definir o técnico no cadastro do local. </span></li>
        	@endif
        </ul>
    </div>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Solicitante: {{$servico->solicitante->name}}</li>
        </ul>
    </div>

    	<div class="form-group">
    	    <label for="setor_id">Setor</label>
    	    <input type="text" class="form-control" readonly value={{$servico->equipamento->setor->nome}}>
        </div>
        
    	<div class="form-group">
    	    <label for="setor_id">Equipamento</label>
            <input type="text" class="form-control" readonly value="{{$servico->equipamento->nome}} - {{$servico->equipamento->descricao}}">
        </div>

    	<div class="form-group">
    	    <label for="tipo_servico_id">Tipo de serviço</label>
            <input type="text" class="form-control" readonly value="{{$servico->tipoServico->nome}}">
        </div>

		<div class="form-group">
    		<label for="descricao">Descrição do problema</label>
    		<textarea class="form-control" rows='3' readonly>{{$servico->descricao}}</textarea>        
		</div>
		
        <div class="panel panel-default">
          <div class="panel-heading">          
            <h3 class="panel-title">Mensagens </h3>
          </div>
          <div class="panel-body">
          
          	@forelse($servico->mensagens as $mensagem)
            <div class="list-group">
              <p class="list-group-item ">
              	<strong>Usuário:</strong> {{$mensagem->user->name}} 
              	<span class="pull-right"><strong>Data: </strong> {{date_format($mensagem->created_at, "d/m/Y H:i:s")}}</span> 
              </p>
              <li class="list-group-item">{{$mensagem->mensagem}}</li>              
          	</div>
          	@empty
            <div class="list-group">
              <li class="list-group-item list-group-item-warning">Não existe mensagem para este serviço.</li>              
          	</div>
          	
			@endforelse
			
          </div>
        </div>
        
    		<form method="post" action="{{route('servicos.store_mensagem')}}" name='form'>
    		{{ csrf_field() }}
    			<input type='hidden' name="servico_id" value="{{$servico->id}}">
                <div class="list-group ">
            		<p class="list-group-item active">Escrever Mensagem</p>
                	<textarea class="list-group-item form-control" rows='3' name='mensagem' ></textarea>
                	<button type='submit' class="btn btn-primary">
                		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true" title='Salvar'></span>            	
                		Salvar
                	</button>
              	</div>   	
			</form>
        
       	
        <div class="form-group">
        	@if(Auth::user()->isTecnico())
      		<a class="btn btn-primary" href="{{route('servicos.index', $servico->equipamento->setor->local->id)}}">
	      		<span class="glyphicon glyphicon-cog" aria-hidden="true" title='A executar'></span>
      			Atender
      		</a>
      		@endif
        
      		<a class="btn btn-primary" href="{{route('servicos.index', $servico->equipamento->setor->local->id)}}">
	      		<span class="glyphicon glyphicon-repeat" aria-hidden="true" title='A executar'></span>
      			Servicos
      		</a>      		
    	</div>  		
	
    
@endsection
