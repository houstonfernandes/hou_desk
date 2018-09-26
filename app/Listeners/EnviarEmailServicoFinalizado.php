<?php

namespace App\Listeners;

use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Events\ServicoCriado;
use App\Events\ServicoFinalizado;

class EnviarEmailServicoFinalizado
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(ServicoFinalizado $event)
    {
        $servico = $event->getServico();
        
        //$user = \App\User::find(1);//@todo verificar user tecnico
        //$from = $user; //@todo email suporte
        //$user = \Auth::user();
//        $user->notify(new \App\Notifications\ServicoNotification($servico));
/*        $msg = '<p>Foi solicitado um servico do tipo <strong>' . $servico->tipoServico->nome . '</strong>, solicitado por <strong>' . $servico->solicitante->name . '</strong></p>' .
            '<p>Descrição: ' . $servico->descricao . '</p>' .
            '<p>Data: '. date_format($servico->created_at, 'd/m/Y hh:mm');
  */      
        \Mail::to($servico->solicitante)->send(new \App\Mail\ServicoFinalizadoMail($servico));
    }
}
