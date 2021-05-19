<?php

namespace App\Http\Controllers\PVP;

use App\Connector\EveAPI\Kills\KillmailService;
use App\Connector\EveAPI\Universe\ResourceLookupService;
use App\Http\Controllers\Controller;
use App\Pvp\PvpEvent;
use App\Pvp\PvpTypeIdLookup;
use App\Pvp\PvpVictim;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PVPController extends Controller
{
    private KillmailService $killService;
    private ResourceLookupService $resourceService;

    /**
     * PVPController constructor.
     *
     * @param KillmailService       $killService
     * @param ResourceLookupService $resourceService
     */
    public function __construct(KillmailService $killService, ResourceLookupService $resourceService) {
        $this->killService = $killService;
        $this->resourceService = $resourceService;
    }


    public function index() {
        return ['hey.'];
    }

    public function addKillmail(Request $request) {
        $request->validate([
            'passcode' => [
                'required',
                Rule::in([config('tracker.pvp.bridge-passcode')]),
            ],
            'killmail' => ['required', 'json']
        ]);

        $littlekill = json_decode($request->get('killmail'));
        if (!$littlekill) {
            abort(400);
        }

        $kill = $this->killService->getKillmail($littlekill->killID, $littlekill->hash);
        if (!$kill) {
            Log::channel('pvp')->warning(sprintf("Invalid kill info: id:%s hash%s", $littlekill->killID, $littlekill->hash));
            abort(400);
        }

        // Check, if
        PvpTypeIdLookup::populate($kill->victim->ship_type_id);

        $victim = new PvpVictim();
        $victim->fill([
            'killmail_id' => $kill->killmail_id,
            'character_id' => $kill->victim->character_id,
            'corporation_id' => $kill->victim->corporation_id,
            'alliance_id' => $kill->victim->corporation_id ?? null,
            'damage_taken' => $kill->victim->damage_taken,
            'ship_type_id' => $kill->victim->ship_type_id,
            'littlekill' => $littlekill,
            'fullkill' => $kill,
            'created_at' => Carbon::parse($kill->killmail_time),
            'pvp_event_id' => PvpEvent::getCurrentEvent()->id
        ]);
        $victim->save();



    }
}
