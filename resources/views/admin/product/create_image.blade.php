@extends('layouts.template')

@section('content')

<h2 class="title">Nova Imagem</h2>
    <ul class="list-group">
    	<li class="list-group-item">Cod. Barra: <strong>{{$product->cod_barra}}</strong></li>
    	<li class="list-group-item">Nome:<strong>{{$product->nome}}</strong></li>
    	<li class="list-group-item">Descrição: <strong>{{$product->descricao}}</strong></li>
    	<li class="list-group-item">Marca: <strong>{{$product->marca}}</strong></li>
    	<li class="list-group-item">Unidade: <strong>{{$product->unidade}}</strong></li>
    </ul>

@include("partial.errors")

<div>
    <form id="uploadForm" action="" enctype="multipart/form-data" method="post" name="form">
        <div class ='form-group'>
            <input id="file" type="file" name="file" class="btn btn-primary"/>
        </div>

        <div class="progress">
            <div class="progress-bar progress-bar-primary" id='progress-bar'  role="progressbar" aria-valuenow="0"
                 aria-valuemin="0" aria-valuemax="100" style="min-width: 2em;">
                0%
            </div>
        </div>

        <div class ='form-group'>
            <input type="button" id='btEnviar' value="Enviar" class="btn btn-primary"/>
            <a href="{{route('admin.product_images.index', $product->id)}}" class="btn btn-primary">Voltar para Produto</a>
        </div>

        <div class="panel panel-primary" id="panel_arquivos_enviados">
            <div class="panel-heading">
                <h3 class="panel-title">Arquivos enviados</h3>
            </div>
            <div class="panel-body">
                <ul  id="arquivos_enviados"></ul>
            </div>
        </div>

    </form>
</div>
@endsection

@push('js')
    <script type="text/javascript" >
        window.url = "{{route('admin.product_images.store', $product->id)}}";
        window._token ="{{ csrf_token() }}";
    </script>
    <!--<script src="{{asset('js/jquery_validation.js')}}"></script>-->
    <script src="{{asset('js/admin/product_images_create.js')}}"></script>
@endpush