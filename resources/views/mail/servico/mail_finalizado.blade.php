@component('mail::message')
# Serviço concluído

<p>
	Foi Finalizado o servico do tipo <strong> {{$servico->tipoServico->nome}} </strong>, solicitado por <strong> {{$servico->solicitante->name}}</strong>
</p>

<p>
	<strong>Equipamento:</strong> {{$servico->equipamento->nome}} 
    @if($servico->equipamento->descricao)
    	 - {{$servico->equipamento->descricao}}
    @endif 
</p>

<p>
	<strong>Descrição:</strong> {{$servico->descricao }}
</p>
<p>
	<strong>Local:</strong> {{$servico->equipamento->setor->local->nome}} - <strong>Setor: </strong> {{$servico->equipamento->setor->nome}}
</p>
<p>
	<strong>Data:</strong> {{date_format($servico->updated_at, 'd/m/Y H:i')}}
</p>
<p>
	<strong>Solução:</strong> {{$servico->solucao}}
</p>

<a href="{{'http://3b040298abee.sn.mynetname.net:8001/servicos/consultar/' . $servico->id}}"  class="btn btn-primary">
	Acessar Serviço
</a>

@endcomponent
