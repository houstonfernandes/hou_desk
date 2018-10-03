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
                	<option value=''>todos</option>
                	@foreach($locais as $local)            	
                		<option value="{{$local->id}}" {{$local->id==old('local_id')?'selected':''}}>{{$local->nome}}</option>
                	@endforeach
                </select>
                
        	    <label for="tipo_equipamento_id">Tipo de equipamento</label>
                <select id='tipo_equipamento_id' name='tipo_equipamento_id' class="form-control"  autofocus>
                	<option value=''>todos</option>
                	@foreach($tiposEquipamento as $tipoEquipamento)
                	<option value="{{$tipoEquipamento->id}}"  {{$tipoEquipamento->id==old('tipo_equipamento_id')?'selected':''}}>{{$tipoEquipamento->nome}}</option>
                	@endforeach
                </select>
                
                <button type="submit" class="btn btn-default">Buscar</button>
                
                </form>
            </div>
                      
          </div>
        </div>    	
    	
    	
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
            @forelse($equipamentos as $equipamento)
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
			@empty
				<tr>
					<td colspan='4' class='alert-warning'>Nenhum equipamento encontrado.</td>
				</tr>                
            @endforelse
        	</tbody>        	
    	</table>
    </div>
{{--        
    <div id="pages">
    {!! $equipamentos->render() !!}
	</div>
--}}

    
@endsection
