<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Search\SearchCriteria;
use App\Http\Controllers\Search\SearchQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class SearchController extends Controller
{

    /** @var BarkController */
    private $bc;

    /**
     * SearchController constructor.
     *
     * @param BarkController $bc
     */
    public function __construct(BarkController $bc) {
        $this->bc = $bc;
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index() {
        $tiers = DB::table("tier")->select("TIER")->orderBy("TIER")->get();
        $types = DB::table("type")->select("TYPE")->orderBy("TYPE")->get();
        $ships = DB::table("ship_lookup")
                   ->select(["ID", "NAME", "GROUP"])
                    ->whereExists(function ($q) {
                        $q->select(DB::raw(1))->from('runs')->whereRaw("runs.SHIP_ID=ship_lookup.ID");
                    })
                   ->get();
        return view("runs-search.search", [
            "tiers" => $tiers,
            "types" => $types,
            "ships" => $ships,
            "bc" => $this->bc
        ]);
    }

    public function search(Request $request) {

        Validator::make($request->all(), [
            'tier' => 'nullable|numeric|min:0|max:6',
            'type' => ['nullable',Rule::exists("type","TYPE")],
            'ship_id' => ['nullable',Rule::exists("ship_lookup","ID")],
            'hull_size' => 'nullable|exists:ship_lookup,HULL_SIZE',
            'run_date_start' => 'nullable|date',
            'run_date_end' => 'nullable|date|before_or_equal:now',
            'min_run_length_m' => 'nullable|numeric|min:0|max:20',
            'min_run_length_s' => 'nullable|numeric|min:0|max:59',
            'max_run_length_m' => 'nullable|numeric|min:0|max:20',
            'max_run_length_s' => 'nullable|numeric|min:0|max:59',
            'survived' => 'nullable|numeric|min:0|max:1',
            'proving_had' => 'nullable|numeric|min:0|max:1',
            'proving_used' => 'nullable|numeric|min:0|max:1',
            'death_reason' => 'nullable',
            'loot_min' => 'nullable|numeric',
            'loot_max' => 'nullable|numeric',
            'loot_strategy' => 'nullable',
        ])->validate();

        $scb = new SearchQueryBuilder();
        if ($request->filled("tier")) {
            $scb->addCondition(new SearchCriteria("Tier ".$request->get("tier"), "runs", "TIER", "=", $request->get("tier")));
        }
        if ($request->filled("type")) {
            $scb->addCondition(new SearchCriteria($request->get("type")." type", "runs", "TYPE", "=", $request->get("type")));
        }
        if ($request->filled("ship_id")) {
            $scb->addCondition(new SearchCriteria("Ship type: ".DB::table("ship_lookup")->where("ID", $request->get("ship_id"))->value("NAME"), "runs", "SHIP_ID", "=", $request->get("ship_id")));
        }
        if ($request->filled("hull_size")) {
            $scb->addCondition(new SearchCriteria(($request->get("hull_size") ? "Cruiser" : "Frigate")." size ships", "ship_lookup", "HULL_SIZE", "=", $request->get("hull_size")));
        }
        if ($request->filled("run_date_start")) {
            $scb->addCondition(new SearchCriteria("Runs from ".$request->get("run_date_start"), "runs", "RUN_DATE", ">=", $request->get("run_date_start")));
        }
        if ($request->filled("run_date_start")) {
            $scb->addCondition(new SearchCriteria("Runs until ".$request->get("run_date_end"), "runs", "RUN_DATE", "<=", $request->get("run_date_end")));
        }
        if ($request->filled("min_run_length_m")) {
            $sec = ($request->get("min_run_length_m")*60)+($request->get("min_run_length_s"));
            $scb->addCondition(new SearchCriteria("Longer than ".$request->get("min_run_length_m").":".$request->get("min_run_length_s"), "runs", "RUNTIME_SECONDS", ">=", $sec));
        }
        if ($request->filled("max_run_length_m")) {
            $sec = ($request->get("max_run_length_m")*60)+($request->get("max_run_length_s"));
            $scb->addCondition(new SearchCriteria("Shorter than ".$request->get("max_run_length_m").":".$request->get("max_run_length_s"), "runs", "RUNTIME_SECONDS", "<=", $sec));
        }
        if ($request->filled("survived")) {
            $scb->addCondition(new SearchCriteria(($request->get("survived") ? "Successful" : "Failed")." runs", "runs", "SURVIVED", "=", $request->get("survived")));
        }
//        if ($request->get("proving_had") !== null) {
//            $scb->addCondition(new SearchCriteria(($request->get("proving_had") ? "Proving conduit spawned" : "Proving conduit didn't spawn"), "runs", "PVP_CONDUIT_SPAWN", "=", $request->get("proving_had")));
//        }
//        if ($request->get("proving_used") !== null) {
//            $scb->addCondition(new SearchCriteria(($request->get("proving_used") ? "Used proving conduit" : "Did not use proving conduit"), "runs", "PVP_CONDUIT_USED", "=", $request->get("proving_used")));
//        }
        if ($request->filled("death_reason")) {
            $scb->addCondition(new SearchCriteria("Death reason: ".$this->bc->getDeathReasonQQuickBark($request->get("death_reason")), "runs", "DEATH_REASON", "=", $request->get("death_reason")));
        }
        if ($request->filled("loot_strategy")) {
            $scb->addCondition(new SearchCriteria("Looting strategy: ".$this->bc->getLootStrategyDescription($request->get("loot_strategy")), "runs", "LOOT_TYPE", "=", $request->get("loot_strategy")));
        }

        if ($request->filled("loot_min")) {
            $scb->addCondition(new SearchCriteria(number_format($request->get("loot_min"), 0, " ", " ") ." ISK min loot", "runs", "LOOT_ISK", ">=", $request->get("loot_min")));
        }
        if ($request->filled("loot_max")) {
            $scb->addCondition(new SearchCriteria(number_format($request->get("loot_max"), 0, " ", " ") ." ISK max loot", "runs", "LOOT_ISK", "<=", $request->get("loot_max")));
        }

        if ($scb->getConditions()->count() == 0) {
            $error = ValidationException::withMessages([
                '' => ['Please do not submit an empty search.'],
            ]);
            throw $error;
        }

        $query = $scb->getQuery()->paginate(100);
        return view("runs-search.results", [
            'results' => $query->appends($request->all()),
			'conditions' => $scb->getConditions(),
            'link' => route('search.saved', ['uuid' => $scb->persistSearch()])
        ]);
    }


    public function savedSearch(Request  $request, string $uuid) {

        Validator::make($request->all(), [
            'tier' => 'nullable|numeric|min:0|max:6',
            'type' => ['nullable',Rule::exists("type","TYPE")],
            'ship_id' => ['nullable',Rule::exists("ship_lookup","ID")],
            'hull_size' => 'nullable|exists:ship_lookup,HULL_SIZE',
            'run_date_start' => 'nullable|date',
            'run_date_end' => 'nullable|date|before_or_equal:now',
            'min_run_length_m' => 'nullable|numeric|min:0|max:20',
            'min_run_length_s' => 'nullable|numeric|min:0|max:59',
            'max_run_length_m' => 'nullable|numeric|min:0|max:20',
            'max_run_length_s' => 'nullable|numeric|min:0|max:59',
            'survived' => 'nullable|numeric|min:0|max:1',
            'proving_had' => 'nullable|numeric|min:0|max:1',
            'proving_used' => 'nullable|numeric|min:0|max:1',
            'death_reason' => 'nullable',
            'loot_min' => 'nullable|numeric',
            'loot_max' => 'nullable|numeric',
            'loot_strategy' => 'nullable',
        ])->validate();


        if (DB::table("saved_searches")->where('id', $uuid)->doesntExist()) {
            return view('error', [
                'title' => "Can't find this search",
                'message' => "Can't find this search: Probably its expired."
            ]);
        }

        $json = DB::table("saved_searches")->where('id', $uuid)->value("criteria");

        $scb = new SearchQueryBuilder();
        $scb->unserializeConditions($json);
        $query = $scb->getQuery()->paginate(100);
        return view("runs-search.results", [
            'results' => $query->appends($request->all()),
            'conditions' => $scb->getConditions()
        ]);
    }



}
