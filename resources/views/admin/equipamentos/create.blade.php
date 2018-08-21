@extends('layouts.app')

@section('content')

    <h2 class='title'>Novo Equipamento</h2>
    
	<div>
        <ul class="list-group">
        	<li class="list-group-item active">Local: {{$local->nome}}</li>
        	<li class="list-group-item">CNPJ: {{$local->cnpj}}</li>
        	<li class="list-group-item">INEP: {{$local->inep}}</li>            	
        	<li class="list-group-item">email: {{$local->email}}</li>
        	<li class="list-group-item">Tel: {{$local->tel}}</li>
        	<li class="list-group-item">Cel: {{$local->cel}}</li>
        </ul>
    </div>

    <form method="post" action="{{route('admin.equipamentos.store')}}" name='form' >
    {{ csrf_field() }}
      <input type="hidden" name='local_id' value='{{$local->id}}'>
      
    	<div class="form-group">
    	    <label for="setor_id">Setor</label>
            <select id=='setor_id' name='setor_id' class="form-control" required>
            	<option value=''>Selecione uma opção</option>
            	@foreach($local->setores as $setor)
            	<option value="{{$setor->id}}">{{$setor->nome}}</option>
            	@endforeach
            </select>
        </div>

      
      <div class="form-group">
        <label for="nome">Nome</label>
        <input type="text" class="form-control" id="nome" name="nome" value="{{old('nome')}}" placeholder="nome" maxlength="80" required>
      </div>
      
      <div class="form-group">
        <label for="marca">Marca</label>
        <input type="text" class="form-control" id="marca" name="marca" value="{{old('marca')}}" placeholder="marca" maxlength="80">
      </div>

		<div class="form-group">
    		<label for="descricao">Descrição</label>
    		<textarea class="form-control" rows='3' name='descricao'>{{old('descricao')}}</textarea>        
		</div>

      <div class="form-inline">
        <label for="num_patrimonio">Num. patrimonio</label>
        <input type="text" class="form-control" id="num_patrimonio" name="num_patrimonio" value="{{old('num_patrimonio')}}" class='intPositivo' maxlength="11">
        <label for="num_etiqueta">Num. etiqueta</label>
        <input type="text" class="form-control" id="num_etiqueta" name="num_etiqueta" value="{{old('num_etiqueta')}}" class='intPositivo' maxlength="11">
        <label for="data_aquisicao">Data Aquisição</label>
        <input type="text" class="form-control" id="data_aquisicao" name="data_aquisicao" value="{{old('data_aquisicao')}}" class='date' maxlength="10">
      </div>
	
      <div class="form-inline">
        <label for="custo">Custo R$</label>
        <input type="text" class="form-control" id="custo" name="custo" value="{{old('custo')}}" class='moeda' maxlength="10">
        <label for="origem">Origem</label>
        <input type="text" class="form-control" id="origem" name="origem" value="{{old('origem')}}" maxlength="100">
      </div>
      
	<div class="form-group">
	    <label for="tipo_equipamento_id">Tipo de equipamento</label>
        <select id='tipo_equipamento_id' name='tipo_equipamento_id' class="form-control" required>
        	<option value=''>Selecione uma opção</option>
        	@foreach($tiposEquipamentos as $tipoEquipamento)
        	<option value="{{$tipoEquipamento->id}}">{{$tipoEquipamento->nome}}</option>
        	@endforeach
        </select>
    </div>
    
	<input type="hidden" name="situacao" value="1">      
	{{--
	<div class="radio">
    	<label>
    		<input type="radio" name='situacao' value='0' >Inativo
    		<input type="radio" name='situacao' value='1' checked>Ativo
      		<input type="radio" name='situacao' value='2' checked>para manutenção
      		<input type="radio" name='situacao' value='3' checked>para manutenção mais de uma vez
    	</label>
  	</div>
  	--}}
	
    <div class="form-group">
  		<button type="submit" class="btn btn-primary">Confirmar</button>
  		<a class="btn btn-primary" href="{{route('admin.setores.index', $local->id)}}">Cancelar</a>
	</div>  		
	</form>
    
@endsection

@push('js')
    <script src="{{asset('js/jquery_validation.js')}}"></script>
    <script src="{{asset('js/jquery_mask_plugin.js')}}"></script>
    <script src="{{asset('js/jquery_numeric.js')}}"></script>
    <script src="{{asset('js/admin/equipamentos_create.js')}}"></script>
@endpush