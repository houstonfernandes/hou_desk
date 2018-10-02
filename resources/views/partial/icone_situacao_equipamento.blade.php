@if($equipamento->situacao == 0)
	<span class="glyphicon glyphicon-thumbs-down text-danger" aria-hidden="true" title='inativo'></span>
@elseif($equipamento->situacao == 1)
	<span class="glyphicon glyphicon-thumbs-up text-success" aria-hidden="true" title='ativo'></span>
@elseif($equipamento->situacao == 2)
	<span class="glyphicon glyphicon-warning-sign text-success" aria-hidden="true" title='ativo, já foi p/ manutenção'></span>
@elseif($equipamento->situacao == 3)
	<span class="glyphicon glyphicon-warning-sign text-warning" aria-hidden="true" title='ativo'></span>                    		
@endif