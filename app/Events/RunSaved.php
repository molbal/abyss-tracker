<?php

namespace App\Events;

use App\Http\Controllers\Auth\AuthController;
use App\Run;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class RunSaved implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $charId;

    public float $avgIsk;

    public float $sumIsk;

    public int $runsCount;


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
        $channelName = sprintf("runs.save.%d", $this->charId);
        Log::debug("Broadcasting on ".$channelName);

        return new PrivateChannel($channelName);

    }

    /**
     * The event's broadcast name.
     *
     * @return string
     */
    public function broadcastAs()
    {
        return 'run-saved';
    }

    public static function createEventForUser(int $charId) : RunSaved {
        $event = new RunSaved($charId);

        $today = today();
        $event->runsCount = DB::table('runs')->where('CHAR_ID', $charId)->whereDate('RUN_DATE', '=', $today)->count();
        $event->sumIsk = round(DB::table('runs')->where('CHAR_ID', $charId)->whereDate('RUN_DATE', '=', $today)->sum('LOOT_ISK')/1_000_000, 2);
        $event->avgIsk = round(DB::table('runs')->where('CHAR_ID', $charId)->whereDate('RUN_DATE', '=', $today)->avg('LOOT_ISK')/1_000_000, 2);

        return $event;
    }

}
