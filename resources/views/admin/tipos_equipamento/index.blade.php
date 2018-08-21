@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Tipos de Equipamentos</h2>
    	
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.tipos_equipamento.create')}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Novo
    		</a>
    	</div>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>Descricão</th>
            		<th>Ativo</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($tiposEquipamento as $tipoEquipamento)
                <tr>
                    <td>{{$tipoEquipamento->nome}}</td>
                    <td>{{$tipoEquipamento->descricao}}</td>
                    <td>@if ($tipoEquipamento->ativo)
                    		<span class="glyphicon glyphicon-thumbs-up text-success" aria-hidden="true" title='sim'></span>
                    	@else
                    		<span class="glyphicon glyphicon-thumbs-down text-danger" aria-hidden="true" title='não'></span>
                    	@endif
                    </td>
                    <td>
                        <a href = "{{route('admin.tipos_equipamento.edit', $tipoEquipamento->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                       	</a>
	                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.tipos_equipamento.delete', [$tipoEquipamento->id]) }}" data-name = "{{$tipoEquipamento->nome}}" data-msg=" Excluir tipo de equipamento?" data-msg_alert="Atencão só será excluído se não possuir associação." title='Excluir'>                        	
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
    {!! $tiposEquipamento->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
