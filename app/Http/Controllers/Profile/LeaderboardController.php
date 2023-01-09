<?php


    namespace App\Http\Controllers\Profile;


    use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class LeaderboardController extends Controller {

        public function index() {

            $leaderboard_90 = $this->getLeaderboard("-90 day", "", 20);
            $leaderboard_30 = $this->getLeaderboard("-30 day", "", 20);
            $leaderboard_07 = $this->getLeaderboard("-7 day", "", 20);
            $avg_leaderboard_90 = $this->getLeaderboardAverage("-90 day", "", 20);
            $avg_leaderboard_30 = $this->getLeaderboardAverage("-30 day", "", 20);
            $avg_leaderboard_07 = $this->getLeaderboardAverage("-7 day", "", 20);
            $rts_leaderboard_90 = $this->getLeaderboardRuntimeQuickest("-90 day", "", 20);
            $rts_leaderboard_30 = $this->getLeaderboardRuntimeQuickest("-30 day", "", 20);
            $rts_leaderboard_07 = $this->getLeaderboardRuntimeQuickest("-7 day", "", 20);

            return view("leaderboard", ['leaderboard_90' => $leaderboard_90, 'leaderboard_30' => $leaderboard_30, 'leaderboard_07' => $leaderboard_07, 'avgloot_leaderboard_90' => $avg_leaderboard_90, 'avgloot_leaderboard_30' => $avg_leaderboard_30, 'avgloot_leaderboard_07' => $avg_leaderboard_07, 'rtsloot_leaderboard_90' => $rts_leaderboard_90, 'rtsloot_leaderboard_30' => $rts_leaderboard_30, 'rtsloot_leaderboard_07' => $rts_leaderboard_07,]);
        }

        /**
         * Gets the leaderboard pilots
         *
         * @param string $from
         * @param string $to
         *
         * @return array
         */
        public function getLeaderboard(string $from, string $to, int $limit = 10) {

            [$from, $to] = $this->normalizeToAndFrom($from, $to);

            return Cache::remember("leaderboard.$from.$to.$limit", 15, function () use ($from, $to, $limit) {
                return DB::select("select
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


        public function getLeaderboardAverage(string $from, string $to, int $limit = 10) {

            [$from, $to] = $this->normalizeToAndFrom($from, $to);

            return Cache::remember("leaderboard_lootavg.$from.$to.$limit", 15, function () use ($from, $to, $limit) {
                return DB::select("select
       r.CHAR_ID,
       AVG(r.LOOT_ISK) as AVG,
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


        public function getLeaderboardRuntimeQuickest(string $from, string $to, int $limit = 10) {

            [$from, $to] = $this->normalizeToAndFrom($from, $to);

            return Cache::remember("leaderboard_lootrts.$from.$to.$limit", 15, function () use ($from, $to, $limit) {
                return DB::select("select
       r.CHAR_ID,
       AVG(r.RUNTIME_SECONDS) as AVG,
       c.NAME
from runs r
    join chars c on r.CHAR_ID = c.CHAR_ID
    where ('public'=(select p.DISPLAY from privacy p where p.CHAR_ID=c.CHAR_ID and p.PANEL='TOTAL_LOOT')
    or NOT EXISTS(select * from privacy pr where  pr.CHAR_ID=c.CHAR_ID and pr.PANEL='TOTAL_LOOT'))
    and
    r.RUN_DATE>=? AND r.RUN_DATE<=?
    and r.PUBLIC=true
    and r.RUNTIME_SECONDS is not null
group by r.CHAR_ID, c.NAME order by 2 ASC limit $limit;", [$from, $to]);
            });
        }

        /**
         * @param string $from
         * @param string $to
         *
         * @return array
         */
        public function normalizeToAndFrom(string $from, string $to) : array {
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

            return [$from, $to];
        }
    }
