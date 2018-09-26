@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Serviços</h2>
    	<div>
    		<a class="btn btn-primary" href="{{route('servicos.create')}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Nova solicitação
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
            		<th>Setor</th>
            		<th>Solicitante</th>
            		<th>Situação</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($servicos as $servico)
                <tr>
                    <td>{{$servico->descricao}}</td>
                    <td>{{$servico->tipoServico->nome}}</td>
                    <td>{{$servico->equipamento->setor->nome}}</td>
                    <td>{{$servico->solicitante->name}}</td>
                    <td>
                    
                    	@include('partial.situacao_servico')
                    	@if($servico->situacao!=5)                    	
                    		<span class='timericone glyphicon glyphicon-time' data-data_hora="{{$servico->created_at}}" data-tempo_limite="{{$servico->tipoServico->duracaoMinutos()}}" title="{{date_format($servico->created_at, 'd/m/Y H:i:s')}}"></span>
                    	@endif
                    		<span data-livestamp="{{$servico->created_at}}"></span>
                    </td>
                    <td>
                        <a href = "{{route('servicos.consultar', $servico->id) }}" class="btn btn-primary" title='Consultar'>
                        	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                       	</a>
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
@push('js')    
    <script src="{{asset('js/livestamp.js')}}"></script>
    <script src="{{asset('js/timer_icone.js')}}"></script>
@endpush

