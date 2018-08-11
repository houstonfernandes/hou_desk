@extends('layouts.app')

@section('content')
	<div>
		<a class="btn btn-primary" href="{{route('admin.fornecedores.create')}}">Novo</a>
	</div>
	
    <div class="row">
    	<h2 class='title'>Fornecedores</h2>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>CPF / CNPJ</th>
            		<th>tel</th>
            		<th>cel</th>
            		<th>email</th>
            		<th>Funções</th>
            	</tr>
            </thead>
            <tbody>
            @foreach($fornecedores as $fornecedor)
                <tr>
                    <td>{{$fornecedor->nome}}</td>
                    <td>{{$fornecedor->cpf}}</td>
                    <td>{{$fornecedor->tel}}</td>
                    <td>{{$fornecedor->cel}}</td>
                    <td>{{$fornecedor->email}}</td>
                    <td>
                        <a href = "{{route('admin.fornecedores.edit', $fornecedor->id) }}" class="btn btn-primary">Editar</a>
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.fornecedores.delete', $fornecedor->id) }}" data-name = "{{$fornecedor->nome}}" data-msg=" Excluir fornecedor?" data-msg_alert="Atencão só será excluído se não possuir compra.">Excluir</button>                                                                            
                    </td>
                </tr>
            @endforeach
        	</tbody>        	
    	</table>
    </div>
        
    <div id="pages">
    {!! $fornecedores->render() !!}
	</div>

    @include('partial.modal_excluir')
        
@endsection
