<?php

namespace App\Listeners;

use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Partners\ZKillboard;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class CalculateStatsListener
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
     * @param  PvpVictimSaved  $event
     * @return void
     */
    public function handle(PvpVictimSaved $event)
    {
        try {
            $eft = ZKillboard::getZKillboardFit($event->victim->getKillboardLink());
        } catch (BusinessLogicException $e) {
            Log::channel("pvp")->warning("Could not generate fit: ".$e->getMessage());
            return;
        }


    }
}
