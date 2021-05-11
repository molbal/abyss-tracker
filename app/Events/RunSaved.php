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

    public float $iskHour;

    public int $runsCount;

//    public array $runData;

    public int $lastRunId;


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
        $event->iskHour = round((DB::select('select ROUND(c.sum/greatest(c.all_seconds, 3600))*3600 isk_per_hour from (select
   sum(r.LOOT_ISK) sum,
   if(count(r.id)=0,0,sum(coalesce(r.RUNTIME_SECONDS, 20*60))) all_seconds

from date_helper d
     left join runs r on d.day = r.RUN_DATE where r.CHAR_ID = ? and r.RUN_DATE=?
group by d.day, r.char_id
order by d.day asc) c;', [$charId, $today])[0]->isk_per_hour ?? 0)/1_000_000,2);

//        $data = DB::table("v_runall")->where("CHAR_ID", $charId)->orderByDesc('CREATED_AT')->first();
//
//        $gained_loot = DB::table('v_loot_details')->where('RUN_ID', $data['ID'])->get();
//
//        $event->runData = ['data' => $data, 'loot' => $gained_loot];

        $event->lastRunId = DB::table('runs')->where('CHAR_ID', $charId)->max('ID');

        return $event;
    }

}
