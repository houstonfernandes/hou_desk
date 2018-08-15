@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Setores</h2>
    	
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.setores.create',$local->id)}}">
    			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>	
    			Novo
    		</a>
    		<a href = "{{route('admin.locais.index') }}" class="btn btn-primary" title='voltar para locais'>
    			<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
    			Locais
    		</a>
    	</div>
		<div>
            <ul class="list-group">
            	<li class="list-group-item active">Local: {{$local->nome}}</li>
            	<li class="list-group-item">CNPJ: {{$local->cnpj}}</li>
            	<li class="list-group-item">INEP: {{$local->inep}}</li>            	
            	<li class="list-group-item">email: {{$local->email}}</li>
            	<li class="list-group-item">Tel: {{$local->tel}}</li>
            	<li class="list-group-item">Cel: {{$local->cel}}</li>
            </ul>
        </div>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>Descricao</th>
            		<th>Ativo</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($setores as $setor)
                <tr>
                    <td>{{$setor->nome}}</td>
                    <td>{{$setor->descricao}}</td>
                    <td>@if ($setor->ativo)
                    		<span class="glyphicon glyphicon-thumbs-up alert-success" aria-hidden="true" title='sim'></span>
                    	@else
                    		<span class="glyphicon glyphicon-thumbs-down alert-danger" aria-hidden="true" title='não'></span>
                    	@endif
                    </td>
                    <td>
                        <a href = "{{route('admin.setores.edit', $setor->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                       	</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.setores.delete', [$setor->id, $local->id]) }}" data-name = "{{$setor->nome}}" data-msg=" Excluir setor?" data-msg_alert="Atencão só será excluído se não possuir equipamento." title='Excluir'>                        	
                        	<span class="glyphicon glyphicon-trash" aria-hidden="true"></span>
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
    {!! $setores->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
