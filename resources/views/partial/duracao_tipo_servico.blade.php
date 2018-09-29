@if($tipoServico->duracao_unidade == 'h')
	{{($tipoServico->duracao == 1)? 'hora': 'horas'}}	
@elseif($tipoServico->duracao_unidade == 'm')
	{{($tipoServico->duracao == 1)? 'minuto': 'minutos'}}
@elseif($tipoServico->duracao_unidade == 'd')
	{{($tipoServico->duracao == 1)? 'dia': 'dias'}}
@endif
