@extends('layouts.template')

@section('content')

<h2 class="title">Novo Usuário</h2>

@include("partial.errors")

<div>
    <form action="{{route('admin.users.store')}}" method="post" name="form">
        {{ csrf_field() }}
        
        <div class ='form-group'>
        	<label for="local">Local</label>
            <select id=='local_id' name='local_id' class="form-control" required>
            	<option value=''>Selecione uma opção</option>
            	@foreach($locais as $local)
            	<option value="{{$local->id}}" {{ $local->id == old('local_id')? "selected":"" }}>{{$local->nome}}</option>
            	@endforeach
            </select>
        </div>
        
        
        <div class ='form-group'>
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" placeholder="Nome" value="{{ old('name') }}" required>
        </div>

        <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ old('email') }}" required>
        </div>

        <div class="form-group">
            <label for="password">Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Senha" required>
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-md-4 control-label">Confirme a Senha</label>
            <input id="password-confirm" type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
        </div>

        <div class="form-group">
            <label for="lembrete">Lembrete</label>
            <input type="text" class="form-control" id="lembrete" name="lembrete" placeholder="Lembrete de Senha" value="{{ old('lembrete') }}">
        </div>

        <div class ='form-group'>
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ old('endereco') }}" maxlength="120">
        </div>

        <div class ='form-group'>
            <label for="numero">Número</label>
            <input type="text" class="form-control" id="endereco" name="numero" value="{{ old('numero') }}" maxlength="10">
        </div>

        <div class ='form-group'>
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control" id="complemento" name="complemento" value="{{ old('complemento') }}" maxlength="80">
        </div>

        <div class ='form-group'>
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="{{ old('bairro') }}" maxlength="80">
        </div>


        <div class ='form-inline'>
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="{{ old('cidade') }}" maxlength="80">
            <label for="UF">UF</label>
            
            <select name="uf"  class="form-control">
                <option value="">
                    Selecione
                </option>

            @foreach(ufBrasil() as $uf=> $ufName)
                    <option value="{{$uf}}">
                        {{$ufName}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class ='form-inline'>
            <label for="tel">Telefone</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="{{ old('tel') }}" maxlength="14">
            <label for="cel">Celular</label>
            <input type="tel" class="form-control" id="cel" name="cel" value="{{ old('cel') }}" maxlength="14">
        </div>

        <div class="form-group">
            <input type="submit" value='Confirmar' class="btn btn-primary">
            <a class="btn btn-primary" href="{{route('admin.users.index')}}">Cancelar</a>
        </div>
    </form>
</div>

@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/admin/users_create.js')}}"></script>
@endpush
