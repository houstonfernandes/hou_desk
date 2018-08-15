@extends('layouts.app')

@section('content')
	<div>
		<a class="btn btn-primary" href="{{route('admin.clientes.create')}}">Novo</a>
	</div>
	
    <div class="row">
    	<h2 class='title'>
    		Clientes
    	</h2>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>CPF/CNPJ</th>
            		<th>tel</th>
            		<th>cel</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @foreach($clientes as $cliente)
                <tr>
                    <td>{{$cliente->nome}}</td>
                    <td>{{$cliente->cpf}}</td>
                    <td>{{$cliente->tel}}</td>
                    <td>{{$cliente->cel}}</td>
                    <td>
                        <a href = "{{route('admin.clientes.edit', $cliente->id) }}" class="btn btn-primary">Editar</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.clientes.delete', $cliente->id) }}" data-name = "{{$cliente->nome}}" data-msg=" Excluir cliente?" data-msg_alert="Atencão só será excluído se não possuir movimentação.">Excluir</button>                                                                            
                    </td>
                </tr>
            @endforeach
        	</tbody>        	
    	</table>
    </div>
        
    <div id="pages">
    {!! $clientes->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
