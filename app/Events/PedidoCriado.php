<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Pedido;

/**evento após criar(gravar um pedido no sistema
 *@since 04/05/2018 
 * @author houston
 *
 */
class PedidoCriado
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $pedido;
    /**
     * Create a new event instance.
     *
     * @return void     * 
     * 
     */    
    public function __construct(Pedido $pedido)
    {
        $this->pedido = $pedido;        
    }
    
    public function getPedido(){
        return $this->pedido;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
