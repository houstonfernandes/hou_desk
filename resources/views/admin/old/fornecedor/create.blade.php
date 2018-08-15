@extends('layouts.app')

@section('content')

    <h2 class='title'>Novo Fornecedor</h2>
    
    
    <form method="post" action="{{route('admin.fornecedores.store')}}" name='form' >
    {{ csrf_field() }}
    
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" placeholder="nome do fornecedor" maxlength="100" required>
      </div>
      
  		<div class="form-inline">
    		<input class="form-check-input" type="radio" name="tipo_fornecedor" id="tipo_fornecedor_fisica" value="0" {{old('tipo_fornecedor',0)==0 ?'checked':''}}>
      		<label class="form-check-label" for="tipo_fornecedor_fisica">Pessoa Física</label>
      		<input class="form-check-input" type="radio" name="tipo_fornecedor" id="tipo_fornecedor_juridica" value="1" {{old('tipo_fornecedor')==1 ?'checked':''}} >
      		<label class="form-check-label" for="tipo_fornecedor_juridica">Pessoa jurídica</label>  		
	</div>	

	<div class="form-inline">
		<label for="cpf"> CPF/CNPJ</label>
    	<input type="text" class="form-control" id="cpf" name="cpf" value="{{old('cpf')}}" maxlength="18">
		<label for="nome_fantasia">Nome Fantasia</label>
        <input type="text" class="form-control" id="nome_fantasia" name="nome_fantasia" value="{{old('nome_fantasia')}}" placeholder="nome fantasia - pessoa juridica"  maxlength="100">
	</div>
      
	<div class="form-inline">
		<label for="endereco">Endereço</label>
        <input type="text" class="form-control" id="endereco" name="endereco" value="{{old('endereco')}}" maxlength="100">
		<label for="numero">Número</label>
        <input type="text" class="form-control" id="numero" name="numero" value="{{old('numero')}}" maxlength="10">
		<label for="complemento">Complemento</label>
        <input type="text" class="form-control" id="complemento" name="complemento" value="{{old('complemento')}}">                
	</div>

	<div class="form-inline">
		<label for="bairro">Bairro</label>
        <input type="text" class="form-control" id="bairro" name="bairro" value="{{old('bairro')}}" maxlength="80">
		<label for="cidade">Cidade</label>
        <input type="text" class="form-control" id="cidade" name="cidade" value="{{old('cidade')}}" maxlength="80">
        <label for="UF">UF</label>
        <select id=='uf' name='uf' class="form-control">
        	<option value=''>Selecione uma opção</option>
        	@foreach($ufBrasil as $id=>$value)
        	<option value="{{$id}}">{{$value}}</option>
        	@endforeach
        </select>
	</div>

	<div class="form-group">
		<label for="ponto_ref">Ponto de referência</label>
        <input type="text" class="form-control" id="ponto_ref" name="ponto_ref" value="{{old('ponto_ref')}}">
	</div>
	
    <div class ='form-inline'>
        <label for="tel">Telefone</label>
        <input type="tel" class="form-control" id="tel" name="tel" value="{{ old('tel') }}" maxlength="14">
        <label for="cel">Celular</label>
        <input type="tel" class="form-control" id="cel" name="cel" value="{{ old('cel') }}" maxlength="14">
    </div>
    
    <div class="form-group">
        <label for="email">Email</label>
        <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}">
    </div>

    <div class="form-group">
        <label for="obs">Observações</label>
        <textarea class="form-control" id="obs" name="obs" rows="3">{{old('obs')}}</textarea>
    </div>

    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.fornecedores.index')}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/fornecedores_create.js')}}"></script>
@endpush