<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SearchController extends Controller
{
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
        ]);
    }



}
