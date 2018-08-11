<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

use App\Compra;

/**evento após receber mercadoria de compra
 *@since 15/05/2018 
 * @author houston
 */
class CompraRecebida
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    private $compra;
    /**
     * Create a new event instance.
     *
     * @return void     * 
     * 
     */
    public function __construct(Compra $compra)
    {         
        $this->compra = $compra;        
    }
    
    public function getCompra(){
        return $this->compra;
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
