<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Servico;

class ServicoMail extends Mailable
{
    use Queueable, SerializesModels;

    private $servico;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Servico $servico)
    {
        $this->servico = $servico;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $servico = $this->servico;
        return $this->markdown('mail.servico.mail', compact('servico'));
    }
}
