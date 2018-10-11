@extends('layouts.app')

@section('content')
	
    <div class="row">
    	<h2 class='title'>Relatório Serviços Quantitativo</h2>
    	
        <div class="panel panel-default">
          <div class="panel-heading">
            <h3 class="panel-title">Pesquisar</h3>
          </div>
          <div class="panel-body">

    
        	<div class="form-inline">
        		<form method='post' action="{{route('relatorios.servicos_quantitativo')}}">
        		{{csrf_field()}}
        		
                <label for="dataMin">Datas</label>
                <input type="text" name="dataMin" id="dataMin" class="form-control"> até
                <input type="text" name="dataMax" id="dataMax" class="form-control">
        		
        	    <label for="local_id">Local</label>
                <select id='local_id' name='local_id' class="form-control" >
                	<option value='' selected>todos</option>
                	@foreach($locais as $local)            	
                		<option value="{{$local->id}}" {{($local->id == $local_id)?'selected':''}}>{{$local->nome}}</option>
                	@endforeach
                </select>
            </div>
            
            <div class="form-inline">
        	    <label for="tipo_equipamento_id">Tipo de equipamento</label>
                <select id='tipo_equipamento_id' name='tipo_equipamento_id' class="form-control"  autofocus>
                	<option value=''>todos</option>
                	@foreach($tiposEquipamento as $tipoEquipamento)
                	<option value="{{$tipoEquipamento->id}}"  {{($tipoEquipamento->id == $tipo_equipamento_id)?'selected':''}}>{{$tipoEquipamento->nome}}</option>
                	@endforeach
                </select>

        	    <label for="tipo_servico_id">Tipo de serviço</label>
                <select id='tipo_servico_id' name='tipo_servico_id' class="form-control">
                	<option value=''>todos</option>
                	@foreach($tiposServico as $tipoServico)
                	<option value="{{$tipoServico->id}}"  {{($tipoServico->id == $tipo_servico_id)?'selected':''}}>{{$tipoServico->nome}}</option>
                	@endforeach
                </select>
                
        	    <label for="situacao">Técnico</label>
                <select id='tecnico_id' name='tecnico_id' class="form-control">
                	<option value=''>todos</option>
                	@foreach($tecnicos as $tecnico)
                		<option value="{{$tecnico->id}}" {{($tecnico->id == $tecnico_id )?'selected':''}}>{{$tecnico->name}}</option>
                	@endforeach
                </select>
                
                <button type="submit" class="btn btn-default">
                	Buscar
                </button>
                
                </form>
            </div>
                      
          </div>
        </div>    	
    	
    	@if($servicos)
    	<table class='table table-striped'>
        	<thead>
            	<tr>        	
            		<th>Local</th>
            		<th>Quantidade</th>
            	</tr>
            </thead>
            <tbody>
            @foreach($servicos as $servico)
                <tr>
                    <td>{{$servico->local_nome}}</td>
                    <td>{{$servico->quantidade}}</td>
                </tr>           
            @endforeach
        	</tbody>        	
    	</table> 
    	
   		@else   		
    		<div class="alert alert-warning" role="alert">Nenhum serviço encontrado.</div>
    	@endif
   		
        <div class="container" style="position: relative; height:30vh; width:80vw">
            <canvas id="chart"></canvas>
        </div>

        <div class="container" style="position: relative; height:30vh; width:80vw; margin-top:350px;">
            <canvas id="chart2"></canvas>
        </div>

    </div>
    
@endsection


@push('js')
	<script type="text/javascript">
		let servicos = {!!json_encode($servicos)!!};
		console.log(servicos);
	</script>
	
	<script src="{{asset('js/Chart.js')}}"></script>
	
    <script src="{{asset('js/rel_servicos_quantitativo.js')}}"></script>
@endpush
