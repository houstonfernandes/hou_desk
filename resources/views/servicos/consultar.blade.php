@extends('layouts.app')

@section('content')

    <h2 class='title'>Consultar solicitação de serviço</h2>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">
        		Solicitante: {{$servico->solicitante->name}}        		
        		<span class="pull-right"><strong>Data da solicitação: </strong> {{date_format($servico->created_at, "d/m/Y H:i:s")}}
        			@include('partial.situacao_servico')
        		</span>
        	</li>
        </ul>
    </div>
    
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

		@if($servico->situacao==5)
    		<div class="form-group">
        		<label for="descricao">Solução</label>
        		<textarea class="form-control" rows='3' readonly>{{$servico->solucao}}</textarea>        
    		</div>
		@endif
		
        <div class="panel panel-default">
          <div class="panel-heading">          
            <h3 class="panel-title">Mensagens </h3>
          </div>
          <div class="panel-body">
          
          	@forelse($servico->mensagens as $mensagem)
            <div class="list-group">
              <p class="list-group-item ">
              	@if($mensagem->user->isTecnico())
              		<span class="glyphicon glyphicon-user text-success" aria-hidden="true" title='Em execução'></span>
              		<span class="text-success"><strong> {{$mensagem->user->name}} </strong></span>
              	@else
              		<strong> {{$mensagem->user->name}} </strong>
              	@endif
              	 
              	<span class="pull-right"> {{date_format($mensagem->created_at, "d/m/Y H:i")}}</span> 
              </p>
              <li class="list-group-item">{{$mensagem->mensagem}}</li>              
          	</div>
          	@empty
            <div class="list-group">
              <li class="list-group-item list-group-item-warning">Não existe mensagem para este serviço.</li>              
          	</div>
          	
			@endforelse
			
			@if($servico->situacao != 5)
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
			@endif
          </div>
        </div>
        
		@if(Auth::user()->isTecnico() && $servico->situacao != 5)  
            <div class="panel panel-default">
              <div class="panel-heading">          
                <h3 class="panel-title">Atendimento ao serviço</h3>
              </div>
              <div class="panel-body">      			
            		<form method="post" action="{{route('servicos.atender')}}" name='form_atendimento'>
            		{{ csrf_field() }}
            			<input type='hidden' name="servico_id" value="{{$servico->id}}">
            			<input type='hidden' name="_method" value="put">
            			<div class="form-group">
            				<label for="situacao">Situação</label>
            				<select name="situacao"  class="form-control" required>
            					<option value="">Selecione uma opção 
            					<option value="3">A executar</option>
            					<option value="4">Em execução</option>
            					<option value="5">Finalizado</option>
            				</select>
            			</div>
            			
                    	<div class="form-group">
                    		<label for='solucao'>Solução</label>
                        	<textarea class="form-control" rows='3' name='solucao' title='A solução só será exibida para o usuário aṕos o serviço estar finalizado'>{{$servico->solucao}}</textarea>
                        	<span id="erro_atender"></span>
            			</div>
            			
                		<div class="form-group">
                      			<label>
                        	     	<input type="checkbox" name="notificar_solicitante" value="1"> Notificar solicitante ao finalizar - {{$servico->solicitante->name}}
                        	    </label>
                        </div>
                        
                    	<div class="form-group">
                        	<button type='submit' class="btn btn-primary">
                        		<span class="glyphicon glyphicon-floppy-disk" aria-hidden="true" title='Salvar'></span>            	
                        		Gravar status de serviço
                        	</button>
                        </div>
        			</form>
        		</div>
        	</div>
		@endif
        
       	
        <div class="form-group">        
      		<a class="btn btn-primary" href="{{route('servicos.index', $servico->equipamento->setor->local->id)}}"  title='Voltar para serviços'>
	      		<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
      			Servicos
      		</a>      		
    	</div>  		
	
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_ui.js')}}"></script>
    
    <script src="{{asset('js/servicos_atender.js')}}"></script>
@endpush

