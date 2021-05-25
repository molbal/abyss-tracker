<?php

namespace App\Http\Controllers\PVP;

use App\Connector\EveAPI\Kills\KillmailService;
use App\Connector\EveAPI\Universe\ResourceLookupService;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Misc\ErrorHelper;
use App\Pvp\PvpAlliance;
use App\Pvp\PvpAttacker;
use App\Pvp\PvpCharacter;
use App\Pvp\PvpCorporation;
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
        try {
            $currentEvent = PvpEvent::getCurrentEvent();
            return redirect(route('pvp.get', ['slug' => $currentEvent->slug]));
        } catch (BusinessLogicException $e) {
            return ErrorHelper::errorPage("No ongoing EVE_NT event", "Nothing here right now");
        }
    }

    public function getEvent(string $slug) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $kills = PvpVictim::wherePvpEvent($event)->paginate();

        return view('pvp.event', [
            'event' => $event
        ]);
    }

    public function addKillmail(Request $request) {

        $request->validate([
            'passcode' => [
                'required',
                Rule::in([config('tracker.pvp.bridge-passcode')]),
            ],
            'killmail.utf8Data' => ['required', 'json']
        ]);

        try {
            $currentEvent = PvpEvent::getCurrentEvent();
        } catch (BusinessLogicException $e) {
            return ['success' => true, 'message' => 'Kill ignored - no current Abyss Tracker PVP event'];
        }

        $littlekill = json_decode($request->get('killmail')["utf8Data"]);
        $typeIds = config('tracker.pvp.accept-ids.' . $currentEvent->slug);
        if (!in_array($littlekill->ship_type_id, $typeIds)) {
            return ['success' => true, 'message' => 'Kill ignored - type ID not acccepted', 'acceptedTypeIDs' => $typeIds];
        }

        $kill = $this->killService->getKillmail($littlekill->killID, $littlekill->hash);

        if (!$kill) {
            Log::channel('pvp')->warning(sprintf("Invalid kill info: id:%s hash%s", $littlekill->killID, $littlekill->hash));
            abort(400);
        }

        // Load and save ship
        PvpTypeIdLookup::populate($kill->victim->ship_type_id);

        // Load and save char, corp, and alliance
        PvpCharacter::populate($kill->victim->character_id);
        PvpCorporation::populate($kill->victim->corporation_id);
        PvpAlliance::populate($kill->victim->alliance_id ?? null);

        $victim = new PvpVictim();
        $victim->fill([
            'killmail_id' => $kill->killmail_id,
            'character_id' => $kill->victim->character_id,
            'corporation_id' => $kill->victim->corporation_id,
            'alliance_id' => $kill->victim->alliance_id ?? null,
            'damage_taken' => $kill->victim->damage_taken,
            'ship_type_id' => $kill->victim->ship_type_id,
            'littlekill' => $littlekill,
            'fullkill' => $kill,
            'created_at' => Carbon::parse($kill->killmail_time),
            'pvp_event_id' => $currentEvent->id
        ]);
        $victim->save();



        foreach ($kill->attackers as $attacker) {

            // Load and save ship and weapon
            PvpTypeIdLookup::populate($attacker->ship_type_id ?? null);
            PvpTypeIdLookup::populate($attacker->weapon_type_id ?? null);

            // Load and save char, corp, and alliance
            PvpCharacter::populate($attacker->character_id ?? null);
            PvpCorporation::populate($attacker->corporation_id ?? null);
            PvpAlliance::populate($attacker->alliance_id ?? null);

            $model = new PvpAttacker();
            $model->fill([
                'killmail_id' => $kill->killmail_id,
                'character_id' => $attacker->character_id ?? null,
                'corporation_id' => $attacker->corporation_id ?? null,
                'alliance_id' => $attacker->alliance_id ?? null,
                'damage_done' => $attacker->damage_done,
                'final_blow' => $attacker->final_blow,
                'security_status' => $attacker->security_status,
                'ship_type_id' => $attacker->ship_type_id ?? null,
                'weapon_type_id' => $attacker->weapon_type_id ?? null,
            ]);
            $model->save();
        }

        Log::info('Killmail '.$kill->killmail_id.' saved');
        return ['success' => true, 'message' => 'Killmail '.$kill->killmail_id.' processed and saved'];
    }
}
