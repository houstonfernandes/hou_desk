@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Setores</h2>
    	
    	<div>
    		<a class="btn btn-primary" href="{{route('admin.locais.create')}}">
    			<span class="glyphicon glyphicon-ok" aria-hidden="true"></span>	
    			Novo
    		</a>
    		<a href = "{{route('admin.locais.index') }}" class="btn btn-primary" title='voltar para locais'>
    			<span class="glyphicon glyphicon-repeat" aria-hidden="true"></span>
    			Locais
    		</a>                                                                          
    		
    	</div>

        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">{{$local->nome}}</h3>
          </div>
          <div class="panel-body">
            <ul>
            	<li>CNPJ: {{$local->cnpj}}</li>
            	<li>INEP: {{$local->inep}}</li>            	
            	<li>email: {{$local->email}}</li>
            	<li>Tel: {{$local->tel}}</li>
            	<li>Cel: {{$local->cel}}</li>
            </ul>
          </div>
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
                    <td>{{$setor->ativo?'Sim':'Não'}}</td>
                    <td>
                        <a href = "{{route('admin.setores.edit', $setor->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit" aria-hidden="true"></span>
                       	</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.setores.delete', $setor->id) }}" data-name = "{{$setor->nome}}" data-msg=" Excluir setor?" data-msg_alert="Atencão só será excluído se não possuir equipamento." title='Excluir'>                        	
                        	<span class="glyphicon glyphicon-remove" aria-hidden="true"></span>
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
