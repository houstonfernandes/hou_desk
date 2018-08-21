@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Equipamentos</h2>
    	
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.equipamentos.create',$local->id)}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Novo
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
            	<li class="list-group-item">CNPJ: {{$local->cnpj}}</li>
            	<li class="list-group-item">INEP: {{$local->inep}}</li>            	
            	<li class="list-group-item">email: {{$local->email}}</li>
            	<li class="list-group-item">Tel: {{$local->tel}}</li>
            	<li class="list-group-item">Cel: {{$local->cel}}</li>
            </ul>
        </div>
        @else
        <div class="alert alert-primary">
        	Todos equipamentos
        </div>
        @endif
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>Descricao</th>
            		<th>Num. pat.</th>
            		<th>Situação</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @forelse($equipamentos as $equipamento)
                <tr>
                    <td>{{$equipamento->nome}}</td>
                    <td>{{$equipamento->descricao}}</td>
                    <td>{{$equipamento->num_patrimonio}}</td>
                    <td>@if($equipamento->situacao == 0)
                    		<span class="glyphicon glyphicon-thumbs-down text-danger" aria-hidden="true" title='inativo'></span>
                    	@elseif($equipamento->situacao == 1)
                    		<span class="glyphicon glyphicon-thumbs-up text-success" aria-hidden="true" title='ativo'></span>
                    	@elseif($equipamento->situacao == 2)
                    		<span class="glyphicon glyphicon-warning-sign text-success" aria-hidden="true" title='ativo, já foi p/ manutenção'></span>
                    	@elseif($equipamento->situacao == 3)
                    		<span class="glyphicon glyphicon-warning-sign text-warning" aria-hidden="true" title='ativo'></span>                    		
                    	@endif
                    </td>
                    <td>
                        <a href = "{{route('admin.setores.edit', $equipamento->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                       	</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="#" data-name = "{{$equipamento->nome}}" data-msg=" Excluir setor?" data-msg_alert="Atencão só será excluído se não possuir serviço" title='Excluir'>                        	
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
    {!! $equipamentos->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
