@extends('layouts.app')

@section('content')
    <h2 class='title'>Imagens do produto</h2>
        <ul class="list-group">
    	<li class="list-group-item">Cod. Barra: <strong>{{$product->cod_barra}}</strong></li>
    	<li class="list-group-item">Nome:<strong>{{$product->nome}}</strong></li>
    	<li class="list-group-item">Descrição: <strong>{{$product->descricao}}</strong></li>
    	<li class="list-group-item">Marca: <strong>{{$product->marca}}</strong></li>
    	<li class="list-group-item">Unidade: <strong>{{$product->unidade}}</strong></li>
    </ul>
    
    <a class='btn btn-primary' href="{{ route('admin.product_images.create', $product->id) }}">Nova Imagem</a>
    <a class='btn btn-primary' href="{{ route('admin.products.index') }}">Produtos</a>

    <table class="table">
    <thead>
    <tr>
        <th>Id</th>
        <th>Extensão</th>
        <th>Imagem</th>
        <th>Funções</th>
    </tr>
    </thead>
    <tbody>
    @forelse($images as $image)
        <tr>
            <td>{{$image->id}}</td>
            <td>{{$image->extension}}</td>
            <td><img src="{{ asset('product_images/' . $image->id . '.' . $image->extension) }}" width = '80px'></td>
            <td>
                <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-excluir" data-url="{{route('admin.product_images.delete', [$image->id, $product->id])}}" data-name = "{{$image->id . $image->extension}}" data-msg=" Excluir imagem?" data-msg_alert="Se excluída definitivamente.">Excluir</button>                                                                            
            </td>
        </tr>
    @empty
        <tr>
            <td colspan="4">Nenhuma imagem encontrada.</td>
        </tr>

    @endforelse
    </tbody>
    </table>
    <div id="pages">
        {!! $images->render() !!}
 	</div>

@include('partial.modal_excluir') 	

@endsection

@push('js')
    <script src = "{{asset('js/admin/modal_excluir.js')}}"></script>
@endpush
