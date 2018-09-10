@component('mail::message')
# Solicitação de serviço

Foi criada uma solicitação de serviço pelo hou desk.

@component('mail::button', ['url' => 'http://192.168.0.20:8001/servicos'])
	Acessar
@endcomponent

Obrigado,<br>
{{ config('app.name') }}
@endcomponent
