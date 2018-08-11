@extends('layouts.template')

@section('content')

    <h2 class="title">Gerenciar Papéis</h2>
    <h3>{{$user->name}}</h3>
    @include("partial.errors")

    <div>
        <form action="{{route('admin.users.roles', $user->id) }}" method="post">
            <input type="hidden" name="id" value="{{ $user->id }}">
            <input type="hidden" name="_method" value="put">
            {{ csrf_field() }}
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nome do Perfil</th>
                        <th>Label do Perfil</th>
                        <th>Autorizado</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($roles as $role)
                    <tr>
                        <td> {{ $role->name }}</td>
                        <td> {{ $role->label }}</td>
                        <td>
                            <input type="checkbox" name="roles[]" value="{{$role->id}}" @if($user->roles->contains($role->id)) checked="checked" @endif>
                            
                        </td>
                    </tr>
                    @endforeach

                </tbody>
            </table>

            <div class ='form-group'>
                <input type="submit" value='Confirmar' class="btn btn-primary">
                <a class="btn btn-primary" href="{{route('admin.users.index')}}">Cancelar</a>
            </div>
        </form>
    </div>

@endsection