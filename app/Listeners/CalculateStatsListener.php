<?php

namespace App\Listeners;

use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\EFT\FitHelper;
use App\Http\Controllers\FitsController;
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

            /** @var FitHelper $fitHelper */
            $fitHelper = resolve('App\Http\Controllers\EFT\FitHelper');

            $shipId = FitsController::getShipIDFromEft($eft);
            $fixedEft = $fitHelper->pyfaBugWorkaround($eft, $shipId);

            /** @var FitsController $fitsController */
            $fitsController = resolve('App\Http\Controllers\FitsController');

            if (!$fitsController->submitSvcFitService($eft, $event->victim->killmail_id, config('fits.prefix.pvp'))) {
                throw new \Exception('Could not submit fit to svcfitstat');
            }

        } catch (\Exception $e) {
            Log::channel("pvp")->warning("Could not generate fit: ".$e->getMessage().' '.$e->getTraceAsString());
            return;
        }


    }
}
