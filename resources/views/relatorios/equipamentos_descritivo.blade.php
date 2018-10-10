@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Relatório Equipamentos Descritivo</h2>
    	
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Pesquisar</h3>
          </div>
          <div class="panel-body">

    
        	<div class="form-inline">
        		<form method='post' action="{{route('relatorios.equipamentos_descritivo')}}">
        		{{csrf_field()}}
        	    <label for="local_id">Local</label>
                <select id='local_id' name='local_id' class="form-control" >
                	<option value='' selected>todos</option>
                	@foreach($locais as $local)            	
                		<option value="{{$local->id}}" {{($local->id == $local_id)?'selected':''}}>{{$local->nome}}</option>
                	@endforeach
                </select>
                
                <label for="setor_id">Setor</label>
                <input type='hidden' id='setor_id_value' value='{{$setor_id}}' >
                <select id='setor_id' name='setor_id' class="form-control" >
                		<option value=''>todos</option>
                		
                    	@foreach($local->setores as $setor)
                    		<option value="{{$setor->id}}" {{($setor->id == $setor_id)?'selected':''}}>{{$setor->nome}}</option>                    		
                    	@endforeach
                
                </select>
                @foreach($local->setores as $setor)
                {{$setor->nome}}                    		
                @endforeach
            </div>
            
            <div class="form-inline">
        	    <label for="tipo_equipamento_id">Tipo de equipamento</label>
                <select id='tipo_equipamento_id' name='tipo_equipamento_id' class="form-control"  autofocus>
                	<option value=''>todos</option>
                	@foreach($tiposEquipamento as $tipoEquipamento)
                	<option value="{{$tipoEquipamento->id}}"  {{($tipoEquipamento->id == $tipo_equipamento_id)?'selected':''}}>{{$tipoEquipamento->nome}}</option>
                	@endforeach
                </select>
                
        	    <label for="situacao">Situação</label>
                <select id='situacao' name='situacao' class="form-control">
                	<option value=''>todas</option>
                	@foreach(config('equipamento.situacoes') as $k => $value)
                		<option value="{{$k}}" {{($situacao == $k && $situacao != null )?'selected':''}}>{{$value}}</option>
                	@endforeach
                </select>
                
                <button type="submit" class="btn btn-default">
                	Buscar
                </button>
                
                </form>
            </div>
                      
          </div>
        </div>    	
    	
    	@if($equipamentos)
   		<div class="alert alert-success" role="alert">{{($equipamentos->count()>1)?'foram encontrados:':'foi encontrado:'}} {{$equipamentos->count()}} {{str_plural('equipamento', $equipamentos->count())}}.</div>
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Nome</th>
            		<th>Tipo</th>
            		<th>Descrição</th>            		
            		<th>Num. pat.</th>
            		<th>Num. etiq.</th>
            		<th>Local</th>
            		<th>Setor</th>
            	</tr>
            </thead>
            <tbody>
            @foreach($equipamentos as $equipamento)
                <tr>
                    <td>
                    	{{$equipamento->nome}}
                    	@include('partial.icone_situacao_equipamento')
                    </td>
                    <td>{{$equipamento->tipo_equipamento_nome}}</td>
                    <td>{{$equipamento->descricao}}</td>                    
                    <td>{{$equipamento->num_patrimonio}}</td>
                    <td>{{$equipamento->num_etiqueta}}</td>
                    <td>{{$equipamento->local_nome}}</td>
                    <td>{{$equipamento->setor_nome}}</td>
                </tr>           
            @endforeach
        	</tbody>        	
    	</table> 
    	
   		@else   		
    		<div class="alert alert-warning" role="alert">Nenhum equipamento encontrado.</div>
    	@endif
    	

    </div>
{{--        
    <div id="pages">
    {!! $equipamentos->render() !!}
	</div>
--}}
@endsection


@push('js')
    <script src="{{asset('js/rel_equipamentos_descritivo.js')}}"></script>
@endpush


