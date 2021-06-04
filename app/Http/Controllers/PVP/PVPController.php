<?php

namespace App\Http\Controllers\PVP;

use App\Charts\PvpTopAttackersChart;
use App\Connector\EveAPI\Kills\KillmailService;
use App\Connector\EveAPI\Universe\ResourceLookupService;
use App\Events\PvpVictimSaved;
use App\Exceptions\BusinessLogicException;
use App\Http\Controllers\Controller;
use App\Http\Controllers\EFT\DTO\Eft;
use App\Http\Controllers\EFT\ItemPriceCalculator;
use App\Http\Controllers\Misc\ErrorHelper;
use App\Http\Controllers\ThemeController;
use App\Pvp\PvpAlliance;
use App\Pvp\PvpAttacker;
use App\Pvp\PvpCharacter;
use App\Pvp\PvpCorporation;
use App\Pvp\PvpEvent;
use App\Pvp\PvpTypeIdLookup;
use App\Pvp\PvpVictim;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class PVPController extends Controller
{
    private KillmailService $killService;
    private ItemPriceCalculator $sipc;

    /**
     * PVPController constructor.
     *
     * @param KillmailService     $killService
     * @param ItemPriceCalculator $sipc
     */
    public function __construct(KillmailService $killService, ItemPriceCalculator $sipc) {
        $this->killService = $killService;
        $this->sipc = $sipc;
    }



    public function index() {
        try {
            $currentEvent = PvpEvent::getCurrentEvent();
            return redirect(route('pvp.get', ['slug' => $currentEvent->slug]));
        } catch (BusinessLogicException $e) {
            return ErrorHelper::errorPage("No ongoing EVE_NT event", "Nothing here right now");
        }catch (\Exception $e) {
            return ErrorHelper::errorPage("Error: ".$e->getMessage(), "Something went wrong");
        }
    }

    public function renderToplist(int $eventId) {
        $event = PvpEvent::whereId($eventId)->firstOrFail();
        $topKills = PvpStats::getEventTopKillsPaginator($event, 10);
        return view('pvp.widgets.top-kills', [
            'topKills' => $topKills,
            'event' => $event
        ]);

    }

    public function getEvent(string $slug) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $topShipsChart = PvpStats::getChartContainerTopShips($event);
        $topWeaponsChart = PvpStats::getChartContainerTopWeapons($event);
        $feed =  PvpStats::getEventFeedPaginator($event);

        return view('pvp.event', [
            'event' => $event,
            'topShipsChart' => $topShipsChart,
            'topWeaponsChart' => $topWeaponsChart,

            'feed' => $feed,
        ]);
    }

    public function listTopKills($slug) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $topKills = PvpStats::getEventTopKillsPaginator($event, 50);

        return view('pvp.top-kills', [
            'event' => $event,
            "topKills" => $topKills
        ]);
    }
    public function listKills($slug) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $feed = PvpStats::getEventFeedPaginator($event, 30);

        return view('pvp.feed', [
            'event' => $event,
            "feed" => $feed
        ]);
    }

    public function getKill(int $killId) {
        try {
            $victim = PvpVictim::whereKillmailId($killId)->firstOrFail();
        }
        catch (\Exception $e) {
            return ErrorHelper::errorPage('This killmail is not yet synchronized to the Abyss Tracker', get_class($e));
        }

        try {
            $eft = Eft::loadPvpFit($killId);
        }
        catch (\Exception $e) {
            return ErrorHelper::errorPage('This killmail is not yet synchronized to the Abyss Tracker - you may see the original one in zKillboard: '.$victim->getKillboardLink(),"Abyss Tracker temporarily over capacity");
        }

        $attackers = PvpStats::getTopAttackersChart($victim);


        return view('pvp.kill', [
            'victim' => $victim,
            'ship_price' => $this->sipc->getFromTypeId($victim->ship_type_id)->getAveragePrice(),
            'items_price' => $eft->getItemsValue(),
            'fit_quicklook' => $eft->getStructuredDisplay(),
            'fit' => json_decode(json_encode(['SHIP_ID' => $victim->ship_type_id])),
            'ship_name' => $victim->ship_type->name,
            'top_damage_chart' => $attackers
        ]);
    }

    public function viewItem(string $slug, int $id) {
        return ErrorHelper::errorPage('Not implemented yet', $slug);
    }
    public function viewCharacter(string $slug, int $id) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $character = PvpCharacter::whereId($id)->firstOrFail();
        $kills = PvpVictim::wherePvpEvent($event)->whereRaw(sprintf("killmail_id in (select killmail_id from pvp_attackers where character_id=%d)", $id))->get();
        $losses = PvpVictim::wherePvpEvent($event)->where('pvp_victims.character_id', '=', $id)->get();

        $feed = $kills->merge($losses)->sortByDesc('created_at');

        $topShips = PvpStats::getShipsChartContainerCharacter($event, $id);
        $topWeps = PvpStats::getChartContainerTopWeaponsCharacter($event, $id);
        $winRate = PvpStats::getChartcontainerWinrateCharacter($event, $id);

        return view('pvp.character', [
            'event' => $event,
            'character' => $character,
            'feed' => $feed,
            'topShipsChart' => $topShips,
            'topWeaponsChart' => $topWeps,
            'winRateChart' => $winRate,
        ]);
    }
    public function viewCorporation(string $slug, int $id) {

        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $corporation = PvpCorporation::whereId($id)->firstOrFail();
        $kills = PvpVictim::wherePvpEvent($event)->whereRaw(sprintf("killmail_id in (select killmail_id from pvp_attackers where corporation_id=%d)", $id))->get();
        $losses = PvpVictim::wherePvpEvent($event)->where('pvp_victims.corporation_id', '=', $id)->get();

        $feed = $kills->merge($losses)->sortByDesc('created_at');

        $topShips = PvpStats::getShipsChartContainerCorporation($event, $id);
        $topWeps = PvpStats::getChartContainerTopWeaponsCorporation($event, $id);
        $winRate = PvpStats::getChartcontainerWinrateCorporation($event, $id);

        return view('pvp.corporation', [
            'event' => $event,
            'corporation' => $corporation,
            'feed' => $feed,
            'topShipsChart' => $topShips,
            'topWeaponsChart' => $topWeps,
            'winRateChart' => $winRate,
        ]);
    }
    public function viewAlliance(string $slug, int $id) {
        $event = PvpEvent::whereSlug($slug)->firstOrFail();

        $alliance = PvpAlliance::whereId($id)->firstOrFail();
        $kills = PvpVictim::wherePvpEvent($event)->whereRaw(sprintf("killmail_id in (select killmail_id from pvp_attackers where alliance_id=%d)", $id))->get();
        $losses = PvpVictim::wherePvpEvent($event)->where('pvp_victims.alliance_id', '=', $id)->get();

        $feed = $kills->merge($losses)->sortByDesc('created_at');

        $topShips = PvpStats::getShipsChartContainerAlliance($event, $id);
        $topWeps = PvpStats::getChartContainerTopWeaponsAlliance($event, $id);
        $winRate = PvpStats::getChartcontainerWinrateAlliance($event, $id);

        return view('pvp.alliance', [
            'event' => $event,
            'alliance' => $alliance,
            'feed' => $feed,
            'topShipsChart' => $topShips,
            'topWeaponsChart' => $topWeps,
            'winRateChart' => $winRate,
        ]);
    }

    /**
     * Handles adding a new killmail
     * @param Request $request
     *
     * @return array
     * @throws \Exception
     */
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
        } catch (BusinessLogicException) {
            return ['success' => true, 'message' => 'Kill ignored - no current Abyss Tracker PVP event'];
        }

        $littlekill = json_decode($request->get('killmail')["utf8Data"]);
        $typeIds = config('tracker.pvp.accept-ids.' . $currentEvent->slug);
        if (!in_array($littlekill->ship_type_id, $typeIds)) {
            return ['success' => true, 'message' => 'Kill ignored - type ID not accepted', 'acceptedTypeIDs' => $typeIds];
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
        try {
            $victim->save();
        }
        catch (\Exception $e) {
            return ['success' => false, 'message' => 'Killmail save failed: '.$e->getMessage().' '.$e->getTraceAsString()];
        }

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


        try {
            $event = new PvpVictimSaved($victim);
            Log::debug('Broadcasting event for '.$victim->getKillboardLink());
            broadcast($event);
            Log::debug('Requesting stats calculation for '.$victim->getKillboardLink());
            PvpVictim::requestStatsCalculation($victim);
        }
        catch (\Exception $e) {
            return ['success' => false, 'message' => 'Could not dispatch event: '.$e->getMessage().' '.$e->getTraceAsString()];
        }


        try {
            $eft = Eft::loadPvpFit($kill->killmail_id);
            $eft->persistLines($kill->killmail_id);
        }
        catch (\Exception $e) {

        }


        return ['success' => true, 'message' => 'Killmail '.$kill->killmail_id.' processed and saved'];
    }
}
