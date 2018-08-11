@extends('layouts.app')

@section('content')

    <h1>Editar Produto</h1>    
    
	<form action="{{route('admin.products.update', $product->id)}}" method="post" name="form">
        <input type="hidden" name="id" value="{{$product->id}}">
        <input type="hidden" name="_method" value="put">
        {{ csrf_field() }}
    	<div class="form-group">
            <label for="name">Categoria</label>
            <select name="category_id" required class="form-control">
            	<option value="">Selecione a categoria</option>
            	@foreach ($categories as $category)
            		<option value="{{$category->id}}" {{($product->category_id == $category->id)? "selected":""}} > {{$category->name}}</option>
            	@endforeach
            </select>        
		</div>
            
        <div class="form-group">
            <label for="cod_barra">Código de barras</label>
            <input type="text" class="form-control numIntPositivo" id="cod_barra" name="cod_barra" value="{{$product->cod_barra}}" placeholder="código de barras" maxlength='13'>
        </div>
        
        <div class="form-group">
            <label for="nome">Nome</label>
            <input type="text" class="form-control" id="nome" name="nome" value="{{$product->nome}}"aria-describedby="nameHelp" placeholder="nome do produto" maxlength='80' required>
        </div>

        <div class="form-group">
            <label for="marca">Marca</label>
            <input type="text" class="form-control" id="marca" name="marca" value="{{$product->marca}}" maxlength="80">
        </div>
                
        <div class="form-group">
            <label for="descricao">Descrição</label>
            <textarea class="form-control" id="descricao" name="descricao" rows="3">{{$product->descricao}}</textarea>
        </div>
        
        <div class="form-inline">
            <label for="unidade">Unidade</label>
            <select name="unidade" required class="form-control">
            	@foreach ($unidades as $key => $value)
            		<option value="{{$key}}" {{($key == $product->unidade ? "selected":"")}} > {{$value}} - {{$key}}</option>
            	@endforeach
            </select>        
            <label for="qtd_min">Quantidade mínima</label>
            <input type="text" class="form-control numIntPositivo" id="qtd_min" name="qtd_min" value="{{$product->qtd_min}}" maxlength="6">
            <label for="qtd_max">Quantidade máxima</label>
            <input type="text" class="form-control numIntPositivo" id="qtd_max" name="qtd_max" value="{{$product->qtd_max}}" maxlength="6">            
        </div>
        
        
        
        <div class="form-inline">
            <label for="preco">Preço</label>
            <input type="text" class="form-control" id="preco" name="preco" value="{{$product->preco}}" required placeholder="preço do produto" maxlength='7'>
            <label for="preco_promocao">Preço promoção</label>
            <input type="text" class="form-control" id="preco_promocao" name="preco_promocao" value="{{$product->preco_promocao}}" placeholder="preço de promoção" maxlength='7'>
            <input type="hidden" name="promocao" value="0"><!-- para desativar se estiver desmarcado -->
            <input type="checkbox" class="form-check-input" id="promocao" name="promocao" value="1" {{$product->promocao==1 ? "checked ":""}}>
            <label class="form-check-label" for="promocao">Promoção</label>            
        </div>
        
        <div class="form-group">
            <label for="tags">Tags</label>
            <textarea class="form-control" id="tags" name="tags" rows="3">{{$tags}}</textarea>
        </div>

        
        <div class="form-check">
        	<input type="hidden" name="destaque" value="0"><!-- para desativar se estiver desmarcado -->
            <input type="checkbox" class="form-check-input" id="destaque" name="destaque" value="1" {{$product->destaque==1 ? "checked ":""}}>
            <label class="form-check-label" for="destaque">Destaque</label>
        </div>
                
        <div class="form-check">
            <input type="hidden" name="ativo" value="0"><!-- para desativar se estiver desmarcado -->
            <input type="checkbox" class="form-check-input" id="ativo" name="ativo" value="1" {{$product->ativo==1 ? "checked ":""}}>
            <label class="form-check-label" for="ativo">Ativo</label>
        </div>
            
      	<div class="form-group">
  			<button type="submit" class="btn btn-primary">Confirmar</button>
  			<a class="btn btn-primary" href="{{route('admin.products.index')}}">Cancelar</a>
 		</div>
 		
	</form>
	
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/products_edit.js')}}"></script>
@endpush
