<?php

namespace App\Events;

use App\Models\Carteira;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UsuarioRecebeuPagamento
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $carteira;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(Carteira $carteira)
    {
        $this->carteira = $carteira;
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
