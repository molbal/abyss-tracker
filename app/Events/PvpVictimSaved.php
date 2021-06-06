<?php

namespace App\Events;

use App\Pvp\PvpVictim;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class PvpVictimSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;


    public PvpVictim $victim;

    /**
     * PvpVictimSaved constructor.
     *
     * @param PvpVictim $victim
     */
    public function __construct(PvpVictim $victim) {
        $this->victim = $victim;
    }


    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return ['pvp-killmail-saved'];
    }


    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'killmail-saved';
    }
}
