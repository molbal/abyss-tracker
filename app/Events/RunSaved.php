<?php

namespace App\Events;

use App\Http\Controllers\Auth\AuthController;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;


class RunSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $charId;

    /**
     * RunSaved constructor.
     *
     * @param int $charId
     */
    public function __construct(int $charId) {
        Log::debug("Creating RunSaved for ".$charId);
        $this->charId = $charId;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn() {
//    {
//        $channelName = sprintf("runs.save.%d", $this->charId);
//        Log::debug("Broadcasting on ".$channelName);
//
//        return new PrivateChannel($channelName);
        return  ['runs.save'];

    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'run.saved';
    }

}
