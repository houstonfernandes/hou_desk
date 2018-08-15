@extends('layouts.app')

@section('content')

    <h2 class='title'>Editar Cliente</h2>
    
	<form action="{{route('admin.clientes.update', $cliente->id)}}" method="post" name='form'>
        <input type="hidden" name="id" value="{{$cliente->id}}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
    
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{$cliente->nome}}" placeholder="nome do cliente" maxlength="100" required>
      </div>
      
	<div class="form-inline">
		<input type='hidden' id='tipo_cliente' value="{{$cliente->tipo_cliente}}">
  		<input class="form-check-input" type="radio" name="tipo_cliente" id="tipo_cliente_fisica" value="0" {{$cliente->tipo_cliente=='0' ?'checked':''}} disabled>
  		<label class="form-check-label" for="tipo_cliente_fisica">Pessoa Física</label>
  		<input class="form-check-input" type="radio" name="tipo_cliente" id="tipo_cliente_juridica" value="1" {{$cliente->tipo_cliente=='1' ?'checked':''}} disabled>
  		<label class="form-check-label" for="tipo_cliente_juridica">Pessoa jurídica</label>  		
	</div>

	<div class="form-inline">
		<label for="cpf"> CPF/CNPJ</label>
        <input type="text" class="form-control" value="{{$cliente->cpf}}" readonly>	
		<label for="nome_fantasia">Nome Fantasia</label>
        <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{$cliente->nome_fantasia}}" placeholder="nome fantasia - pessoa juridica"  maxlength="100">
	</div>
      
	<div class="form-inline">
		<label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{$cliente->endereco}}" maxlength="100">
		<label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{$cliente->numero}}" maxlength="10">
		<label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{$cliente->complemento}}">
	</div>

	<div class="form-inline">
		<label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{$cliente->bairro}}" maxlength="80">
		<label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{$cliente->cidade}}" maxlength="80">
        <label for="UF">UF</label>
        <select id=='uf' name='uf' class="form-control">
        	<option value=''>Selecione uma opção</option>
        	@foreach($ufBrasil as $id=>$value)
        	<option value="{{$id}}" {{ $cliente->uf==$id? "selected":"" }}>{{$value}}</option>
        	@endforeach
        </select>
	</div>

	<div class="form-group">
		<label for="ponto_ref">Ponto de referência</label>
        <input type="text" class="form-control" id="ponto_ref" name="ponto_ref" value="{{$cliente->ponto_ref}}">
	</div>
	
    <div class ='form-inline'>
        <label for="tel">Telefone</label>
        <input type="tel" class="form-control" id="tel" name="tel" value="{{ $cliente->tel }}" maxlength="14">
        <label for="cel">Celular</label>
        <input type="tel" class="form-control" id="cel" name="cel" value="{{ $cliente->cel }}" maxlength="14">
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $cliente->email }}">
    </div>

    <div class="form-group">
        <label for="obs">Observações</label>
        <textarea class="form-control" id="obs" name="obs" rows="3">{{$cliente->obs}}</textarea>
    </div>

    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.clientes.index')}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/clientes_edit.js')}}"></script>
@endpush
