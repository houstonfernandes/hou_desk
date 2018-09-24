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
            <div class="list-group">
              <p class="list-group-item ">
              	<strong>Usuário:</strong> sjdsjdhsdjsdjsd 
              	<span class="pull-right"><strong>Data: </strong> 24/09/2018 15:18 </span> 
              </p>
              <li class="list-group-item">Dapibus ac facilisis indfdflçdçlfçl dçlfçldffdflçdfçdlfç dfldçf ldfçdl fçdl fçdlfçdfldçfldfçdlfçd,dçcd dfdfdfd dfdf df</li>              
          	</div>

            <div class="list-group">
              <p class="list-group-item ">
              	<strong>Usuário:</strong> sjdsjdhsdjsdjsd 
              	<span class="pull-right"><strong>Data: </strong> 24/09/2018 15:18 </span> 
              </p>
              <li class="list-group-item">Dapibus ac facilisis indfdflçdçlfçl dçlfçldffdflçdfçdlfç dfldçf ldfçdl fçdl fçdlfçdfldçfldfçdlfçd,dçcd dfdfdfd dfdf df</li>              
          	</div>

            <div class="list-group">
              <p class="list-group-item ">
              	<strong>Usuário:</strong> sjdsjdhsdjsdjsd 
              	<span class="pull-right"><strong>Data: </strong> 24/09/2018 15:18 </span> 
              </p>
              <li class="list-group-item">Dapibus ac facilisis indfdflçdçlfçl dçlfçldffdflçdfçdlfç dfldçf ldfçdl fçdl fçdlfçdfldçfldfçdlfçd,dçcd dfdfdfd dfdf df</li>              
          	</div>
          </div>
        </div>
        
    		<form method="post" action="#" name='form'>
    			<input type='hidden' name="user_id" value="{{Auth::user()->id}}">   		
    		
            <div class="list-group ">
        		<p class="list-group-item active">Escrever Mensagem</p>
            	<textarea class="list-group-item form-control" rows='3' ></textarea>
            	<button type='button' class="btn btn-primary">Salvar</button>
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
