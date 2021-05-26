<?php


	namespace App\Http\Controllers\PVP;


	use App\Pvp\PvpEvent;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class PvpStats {

        public static function getEventTopKillsPaginator(PvpEvent $event, int $itemsPerPage = 15) {
            return
                DB::table("pvp_attackers", "attacker")
                  ->join("pvp_characters as pc", function($join){
                      $join->on("attacker.character_id", "=", "pc.id");
                  })
                  ->join("pvp_victims as pv", function($join){
                      $join->on("pv.killmail_id", "=", "attacker.killmail_id");
                  })
                  ->select(["pc.name", "pc.id", DB::raw("count(attacker.id) as kills_count")])
                  ->where("pv.pvp_event_id", "=", $event->id)
                  ->orderBy("kills_count","desc")
                  ->groupBy("pc.id")
                  ->paginate($itemsPerPage);
	    }
	}
