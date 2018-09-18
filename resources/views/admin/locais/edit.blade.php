@extends('layouts.app')

@section('content')

    <h2 class='title'>Editar Local</h2>
    
	<form action="{{route('admin.locais.update', $local->id)}}" method="post" name='form'>
        <input type="hidden" name="id" value="{{$local->id}}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
    
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{$local->nome}}" placeholder="nome do fornecedor" maxlength="100" required>
      </div>

	<div class="form-inline">
		<label for="cnpj"> CNPJ</label>
        <input type="text" class="form-control" value="{{$local->cnpj}}" readonly>
        <label for="inep"> INEP</label>
    	<input type="text" class="form-control" id="inep" name="inep" value="{{$local->inep}}" maxlength="18">        	
		<label for="nome_fantasia">Nome Fantasia</label>
        <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{$local->nome_fantasia}}" placeholder="nome fantasia - pessoa juridica"  maxlength="100">
	</div>
      
	<div class="form-inline">
		<label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{$local->endereco}}" maxlength="100">
		<label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{$local->numero}}" maxlength="10">
		<label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{$local->complemento}}">
	</div>

	<div class="form-inline">
		<label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{$local->bairro}}" maxlength="80">
		<label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{$local->cidade}}" maxlength="80">

        <input type="hidden" name="uf" value="RJ">
{{--
        <label for="UF">UF</label>
        <select id=='uf' name='uf' class="form-control">
        	<option value=''>Selecione uma opção</option>
        	@foreach($ufBrasil as $id=>$value)
        	<option value="{{$id}}" {{ $local->uf==$id? "selected":"" }}>{{$value}}</option>
        	@endforeach
        </select>
--}}
	</div>

	<div class="form-group">
		<label for="ponto_ref">Ponto de referência</label>
        <input type="text" class="form-control" id="ponto_ref" name="ponto_ref" value="{{$local->ponto_ref}}">
	</div>
	
	<div class="form-group">
		<label for="cep">CEP</label>
        <input type="text" class="form-control" id="cep" name="cep" value="{{$local->cep}}">
	</div>
	
    <div class ='form-inline'>
        <label for="tel">Telefone</label>
        <input type="tel" class="form-control" id="tel" name="tel" value="{{ $local->tel }}" maxlength="14">
        <label for="cel">Celular</label>
        <input type="tel" class="form-control" id="cel" name="cel" value="{{ $local->cel }}" maxlength="14">
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $local->email }}">
    </div>

    <div class="form-group">
        <label for="obs">Observações</label>
        <textarea class="form-control" id="obs" name="obs" rows="3">{{$local->obs}}</textarea>
    </div>
            
    <div class="form-group">
        <label for="tecnico_id">Técnico</label>
        <select id='tecnico_id' name='tecnico_id' class="form-control" required>
        	<option value='' selected>Selecione uma opção</option>
        	@foreach($tecnicos as $tecnico)
        	<option value="{{$tecnico->id}}" {{ $local->tecnico_id==$tecnico->id? "selected":"" }}>{{$tecnico->name}} - {{$tecnico->local->nome}}</option>
        	@endforeach
        </select>
	</div>
	
    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.locais.index')}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/locais_edit.js')}}"></script>
@endpush
