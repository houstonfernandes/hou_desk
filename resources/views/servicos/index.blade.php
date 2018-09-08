@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Serviços</h2>
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.equipamentos.create',$local->id)}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Nova solicitação
    		</a>
    		<a class="btn btn-primary" href="{{route('admin.tipos_equipamento.index')}}">
    			<span class="glyphicon glyphicon-list-alt" aria-hidden="true"></span>	
    			Tipos de equipamentos
    		</a>
    		
    		<a href = "{{route('admin.locais.index') }}" class="btn btn-primary" title='voltar para locais'>
    			<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
    			Locais
    		</a>
    	</div>
    	@if($local)
		<div>
            <ul class="list-group">
            	<li class="list-group-item active">Local: {{$local->nome}}</li>
            	<li class="list-group-item">email: {{$local->email}}</li>
            	<li class="list-group-item">Tel: {{$local->tel}}</li>
            	<li class="list-group-item">Cel: {{$local->cel}}</li>
            </ul>
        </div>
        @else
        <div class="alert alert-primary">
        	Todos serviços
        </div>
        @endif
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Descrição</th>
            		<th>Tipo</th>
            		<th>Solicitante</th>
            		<th>Técnico</th>
            		<th>Situação</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($servicos as $servico)
                <tr>
                    <td>{{$servico->descricao}}</td>
                    <td>{{$servico->tipoServico->nome}}</td>
                    <td>{{$servico->solicitante->nome}}</td>
                    <td>{{$servico->tecnico->nome}}</td>
                    <td>@if($servico->situacao == 0)
                    		<span class="glyphicon glyphicon-thumbs-down text-danger" aria-hidden="true" title='Solicitação iniciada'></span>
                    	@elseif($servico->situacao == 1)
                    		<span class="glyphicon glyphicon-thumbs-up text-success" aria-hidden="true" title='Tecnico notificado'></span>
                    	@elseif($servico->situacao == 2)
                    		<span class="glyphicon glyphicon-warning-sign text-success" aria-hidden="true" title='Técnico ciente'></span>
                    	@elseif($servico->situacao == 3)
                    		<span class="glyphicon glyphicon-warning-sign text-warning" aria-hidden="true" title='A executar'></span>                    		
                    	@elseif($servico->situacao == 4)
                    		<span class="glyphicon glyphicon-warning-sign text-warning" aria-hidden="true" title='Em execução'></span>
                    	@elseif($servico->situacao == 5)
                    		<span class="glyphicon glyphicon-warning-sign text-warning" aria-hidden="true" title='Finalizado'></span>
                    	@endif
                    </td>
                    <td>
                        <a href = "{{route('admin.equipamentos.edit', $equipamento->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                       	</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.equipamentos.delete', $equipamento->id)}}" data-name = "{{$equipamento->nome}}" data-msg=" Excluir equipamento?" data-msg_alert="Atencão só será excluído se não possuir serviço" title='Excluir'>                        	
                        	<span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
			@empty
				<tr>
					<td colspan='6' class='alert-warning'>Nenhum registro encontrado.</td>
				</tr>                
            @endforelse
        	</tbody>
    	</table>
    </div>
        
    <div id="pages">
    {!! $servicos->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
