<?php

namespace App\Listeners;

use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\EFT\FitHelper;
use App\Http\Controllers\FitsController;
use App\Http\Controllers\Partners\ZKillboard;
use App\Pvp\PvpVictim;
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
        PvpVictim::requestStatsCalculation($event->victim);
    }
}
