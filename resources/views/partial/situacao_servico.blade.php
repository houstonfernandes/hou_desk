@if($servico->situacao == 0)
	<span class="glyphicon glyphicon-plus text-success" aria-hidden="true" title='Solicitação iniciada'></span>
@elseif($servico->situacao == 1)
	<span class="glyphicon glyphicon-envelope text-success" aria-hidden="true" title='Tecnico notificado'></span>
@elseif($servico->situacao == 2)
	<span class="glyphicon glyphicon-user text-success" aria-hidden="true" title='Técnico ciente'></span>
@elseif($servico->situacao == 3)
	<span class="glyphicon glyphicon-wrench text-warning" aria-hidden="true" title='A executar'></span>                    		
@elseif($servico->situacao == 4)
	<span class="glyphicon glyphicon-wrench text-danger" aria-hidden="true" title='Em execução'></span>
@elseif($servico->situacao == 5)
	<span class="glyphicon glyphicon-thumbs-up text-success" aria-hidden="true" title='Finalizado'></span>
@endif
