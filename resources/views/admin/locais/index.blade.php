@extends('layouts.app')

@section('content')
    <div class="row">
    	<h2 class='title'>Locais</h2>
    	
		<div>			
    		<a class="btn btn-primary" href="{{route('admin.locais.create')}}">
    			<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>	
    			Novo
    		</a>
    	</div>  
    	  	
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>CNPJ</th>
            		<th>tel</th>
            		<th>cel</th>
            		<th>email</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @foreach($locais as $local)
                <tr>
                    <td>{{$local->nome}}</td>
                    <td>{{$local->cnpj}}</td>
                    <td>{{$local->tel}}</td>
                    <td>{{$local->cel}}</td>
                    <td>{{$local->email}}</td>
                    <td>
                        <a href = "{{route('admin.setores.index', $local->id) }}" class="btn btn-primary" title="Setores">
                        	<span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>
                        </a>
                        <a href = "{{route('admin.equipamentos.index', $local->id) }}" class="btn btn-primary" title="Equipamentos">
                        	<span class="glyphicon glyphicon-wrench" aria-hidden="true"></span>
                        </a>                                                                            
                        <a href = "{{route('admin.locais.edit', $local->id) }}" class="btn btn-primary" title='Editar'>
                        	<span class="glyphicon glyphicon-edit text-success" aria-hidden="true"></span>
                        </a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.locais.delete', $local->id) }}" data-name = "{{$local->nome}}" data-msg=" Excluir local?" data-msg_alert="Atencão só será excluído se não possuir usuário." title='Excluir'>
                        	<span class="glyphicon glyphicon-trash text-danger" aria-hidden="true"></span>
                        </button>
                                                                                                    
                    </td>
                </tr>
            @endforeach
        	</tbody>        	
    	</table>
    </div>
        
    <div id="pages">
    {!! $locais->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
