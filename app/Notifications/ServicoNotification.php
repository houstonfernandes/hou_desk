<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class ServicoNotification extends Notification
{
    use Queueable;
    
    private $servico;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($servico)
    {
        $this->servico = $servico;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        $msg = '<p>Foi solicitado um servico do tipo <strong>' . $this->servico->tipoServico->nome . '</strong>, solicitado por <strong>' .$this->servico->solicitante->name . '</strong></p>' .
            '<p>Descrição: ' . $this->servico->descricao . '</p>' .
            '<p>Data: '. date_format($this->servico->created_at, 'd/m/Y hh:mm');        
        
        return (new MailMessage)
            ->subject('Solicitação de serviço')
            //->from(config('app.email'),config('app.name'))
            ->from(config('mail.from.address'),config('app.name'))
            
//        ->greeting('Olá!')

//        ->line('O sistema '  . config('app.name') . ' Registrou um novo serviço.')
            ->action('Acessar', route('servicos.index'))
            ->markdown('notification.servico.novo', compact('msg'));
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
