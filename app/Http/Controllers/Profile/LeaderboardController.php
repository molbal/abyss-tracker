<?php


	namespace App\Http\Controllers\Profile;


	use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class LeaderboardController  {

        /**
         * Gets the leaderboard pilots
         * @param string $from
         * @param string $to
         *
         * @return array
         */
        public function getLeaderboard(string $from, string $to, int $limit = 10) {

            if (trim($from) == "" || !strtotime($from)) {
                $from = date("Y-m-d");
            } else {
                $from = date("Y-m-d", strtotime($from));
            }
            if (trim($to) == "" || !strtotime($to)) {
                $to = date("Y-m-d");
            } else {
                $to = date("Y-m-d", strtotime($to));
            }

            return Cache::remember("leaderboard.$from.$to.$limit", 15, function() use ($from, $to, $limit) {
               return  DB::select("select
       r.CHAR_ID,
       count(r.ID) as COUNT,
       c.NAME
from runs r
    join chars c on r.CHAR_ID = c.CHAR_ID
    where ('public'=(select p.DISPLAY from privacy p where p.CHAR_ID=c.CHAR_ID and p.PANEL='TOTAL_LOOT')
    or NOT EXISTS(select * from privacy pr where  pr.CHAR_ID=c.CHAR_ID and pr.PANEL='TOTAL_LOOT'))
    and
    r.RUN_DATE>=? AND r.RUN_DATE<=?
    and r.PUBLIC=true
group by r.CHAR_ID, c.NAME order by 2 desc limit $limit;", [$from, $to]);
            });

	    }
	}
