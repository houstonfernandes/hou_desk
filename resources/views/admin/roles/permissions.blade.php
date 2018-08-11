@extends('layouts.template')
@section('content')

<h2 class="title">Gerenciar Permissões</h2>
<h3>{{$role->label}}</h3>

@include("partial.errors")

<div>
    <form action="{{route('admin.roles.permissions', $role->id)}}" method="post">
        <input type="hidden" name="id" value="{{ $role->id }}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
        <table class="table table-striped table-responsive">
            <thead>
                <tr>
                    <th>Nome da Permissão</th>
                    <th>Label da Permissão</th>
                    <th>Autorizado</th>
                </tr>
            </thead>
            <tbody>
                @foreach($permissions as $permission)
                <tr>
                    <td> {{ $permission->name }}</td>
                    <td> {{ $permission->label }}</td>
                    <td>
                        @if($role->name=='admin')
                            <input type="checkbox" name="permissions[]" checked="checked" disabled>
                        @else
                            <input type="checkbox" name="permissions[]" value="{{$permission->id}}" @if($role->permissions->contains($permission->id)) checked="checked" @endif>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>
        </table>

        <div class="checkbox">
            <label for="select_all">
                <input type="checkbox" id="select_all">
                Selecionar tudo</label>
        </div>

        <div class ='form-group'>
            <input type="submit" value='Confirmar' class="btn btn-primary" @if($role->name=='admin') disabled @endif>
            <a class="btn btn-primary" href="{{route('admin.roles.index')}}">Cancelar</a>
        </div>
    </form>
</div>

@endsection

@push('js')
    <script src="{{asset('js/admin/roles_permissions.js')}}"></script>
@endpush