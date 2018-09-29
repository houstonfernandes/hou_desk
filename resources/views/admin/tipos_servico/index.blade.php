@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Tipos de Serviço</h2>
    	
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.tipos_servico.create')}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Novo
    		</a>
    	</div>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>Duração</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($tiposServico as $tipoServico)
                <tr>
                    <td>{{$tipoServico->nome}}</td>
                    <td>
                    	{{$tipoServico->duracao}}
                    	
                    	@include('partial.duracao_tipo_servico')                    
                    
                    </td>
                    <td>
                        <a href = "{{route('admin.tipos_servico.edit', $tipoServico->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                       	</a>
	                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.tipos_servico.delete', [$tipoServico->id]) }}" data-name = "{{$tipoServico->nome}}" data-msg=" Excluir tipo de serviço?" data-msg_alert="Atencão só será excluído se não possuir associação." title='Excluir'>                        	
                        	<span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span>
                        </button>
                    </td>
                </tr>
			@empty
				<tr>
					<td colspan='4' class='alert-warning'>Nenhum registro encontrado.</td>
				</tr>                
            @endforelse
        	</tbody>        	
    	</table>
    </div>
        
    <div id="pages">
    {!! $tiposServico->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
