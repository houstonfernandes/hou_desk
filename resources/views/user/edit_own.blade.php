@extends('layouts.template')

@section('content')

<h2 class="title">Editar Usuário</h2>
<h3>{{$user->name}}</h3>
<div>
    <form action="{{route('users.update_own', $user->id)}}" method="post">
        <input type="hidden" name="id" value="{{$user->id}}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}

        <div class ='form-group'>
            <label for="name">Nome</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $user->name }}" required>
        </div>

        <div class="form-group">
            <label for="emai1">Email</label>
            <input type="email" class="form-control" id="email" name="email" placeholder="Email" value="{{ $user->email }}" required>
        </div>

        <div class="form-group">
            <label for="password_old">Senha atual</label>
            <input type="password" class="form-control" id="password_old" name="password_old" placeholder="Senha atual" required>
        </div>

        <div class="form-group">
            <label for="password">Nova Senha</label>
            <input type="password" class="form-control" id="password" name="password" placeholder="Nova Senha">
        </div>

        <div class="form-group">
            <label for="password-confirm" class="col-md-4 control-label">Confirme a Senha</label>
            <input id="password-confirm" type="password" class="form-control" id="password_confirmation" name="password_confirmation">
        </div>

        <div class="form-group">
            <label for="lembrete">Lembrete</label>
            <input type="text" class="form-control" id="lembrete" name="lembrete" placeholder="Lembrete de Senha" value="{{ $user->lembrete }}">
        </div>

        <div class ='form-group'>
            <label for="endereco">Endereço</label>
            <input type="text" class="form-control" id="endereco" name="endereco" value="{{ $user->endereco }}" maxlength="120">
        </div>

        <div class ='form-group'>
            <label for="numero">Número</label>
            <input type="text" class="form-control" id="endereco" name="numero" value="{{ $user->numero}}" maxlength="10">
        </div>

        <div class ='form-group'>
            <label for="complemento">Complemento</label>
            <input type="text" class="form-control" id="complemento" name="complemento" value="{{ $user->complemento}}" maxlength="80">
        </div>

        <div class ='form-group'>
            <label for="bairro">Bairro</label>
            <input type="text" class="form-control" id="bairro" name="bairro" value="{{ $user->bairro}}" maxlength="80">
        </div>

        <div class ='form-inline'>
            <label for="cidade">Cidade</label>
            <input type="text" class="form-control" id="cidade" name="cidade" value="{{ $user->cidade}}" maxlength="80">
            <label for="UF">UF</label>
            <select name="uf" class="form-control">
                @foreach(ufBrasil() as $uf=> $ufName)
                    <option value="{{$uf}}" @if($uf==$user->uf) selected="selected" @endif>
                        {{$ufName}}
                    </option>
                @endforeach
            </select>
        </div>

        <div class ='form-inline'>
            <label for="tel">Telefone</label>
            <input type="tel" class="form-control" id="tel" name="tel" value="{{ $user->tel }}" maxlength="14">
            <label for="cel">Celular</label>
            <input type="tel" class="form-control" id="cel" name="cel" value="{{ $user->cel }}" maxlength="14">
        </div>

        <div class ='form-group'>
            <input type="submit" value='Confirmar' class="btn btn-primary">
            <a class="btn btn-primary" href="{{route('admin.users.index')}}">Cancelar</a>
        </div>
    </form>
</div>

@endsection

@push('js')
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
@endpush
