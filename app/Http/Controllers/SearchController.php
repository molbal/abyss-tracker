<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Search\SearchCriteria;
use App\Http\Controllers\Search\SearchQueryBuilder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

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
        $tiers = DB::table("tier")->select("TIER")->get();
        $types = DB::table("type")->select("TYPE")->get();
        $ships = DB::table("ship_lookup")
                   ->select(["ID", "NAME", "GROUP"])
                    ->whereExists(function ($q) {
                        $q->select(DB::raw(1))->from('runs')->whereRaw("runs.SHIP_ID=ship_lookup.ID");
                    })
                   ->get();
        return view("search", [
            "tiers" => $tiers,
            "types" => $types,
            "ships" => $ships,
            "bc" => $this->bc
        ]);
    }

    public function search(Request $request) {

        Validator::make($request->all(), [
            'tier' => 'nullable|numeric|min:1|max:5',
            'type' => ['nullable',Rule::exists("type","TYPE")],
            'ship_id' => 'nullable|numeric',
            'hull_size' => 'nullable|numeric|min:0|max:15',
            'run_date_start' => 'nullable|date',
            'run_date_end' => 'nullable|date',
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
//        dd($request->all());

        $scb = new SearchQueryBuilder();
        if ($request->get("tier")) {
            $scb->addCondition(new SearchCriteria("Tier ".$request->get("tier"), "runs", "TIER", "=", $request->get("tier")));
        }
        if ($request->get("type")) {
            $scb->addCondition(new SearchCriteria($request->get("type")." type", "runs", "TYPE", "=", $request->get("type")));
        }
        if ($request->get("ship_id")) {
            $scb->addCondition(new SearchCriteria("Ship type: ".DB::table("ship_lookup")->where("ID", $request->get("ship_id"))->value("NAME"), "runs", "SHIP_ID", "=", $request->get("ship_id")));
        }
        if ($request->get("hull_size")) {
            $scb->addCondition(new SearchCriteria(($request->get("hull_size") ? "Cruiser" : "Frigate")." size ships", "ship_lookup", "IS_CRUISER", "=", $request->get("hull_size")));
        }
//        DB::enableQueryLog();
        $query = $scb->getQuery()->get();
//        dd(DB::getQueryLog(), $query);
        return view("results", [
            'results' => $query,
			'conditions' => $scb->getConditions()
        ]);
    }



}
