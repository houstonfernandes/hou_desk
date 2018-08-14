@extends('layouts.app')

@section('content')
	<div>
		<a class="btn btn-primary" href="{{route('admin.locais.create')}}">Novo</a>
	</div>
	
    <div class="row">
    	<h2 class='title'>Locais</h2>
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
                        <a href = "{{route('admin.locais.edit', $local->id) }}" class="btn btn-primary">Editar</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.locais.delete', $local->id) }}" data-name = "{{$local->nome}}" data-msg=" Excluir local?" data-msg_alert="Atencão só será excluído se não possuir usuário.">Excluir</button>                                                                            
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
