<?php


	namespace App\Http\Controllers;


	use App\Charts\LootTypesChart;
    use App\Charts\SurvivalLevelChart;
    use App\Http\Controllers\DS\MedianController;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class InfopageController extends Controller {

        /** @var FitSearchController */
        private $fitSearchController;

        /**
         * InfopageController constructor.
         *
         * @param FitSearchController $fitSearchController
         */
        public function __construct(FitSearchController $fitSearchController) {
            $this->fitSearchController = $fitSearchController;
        }


        /**
         * Handles the tier thing
         * @param int $tier
         *
         * @return array
         */
        public function tier(int $tier) {

            $medianCruiser = MedianController::getTierMedian($tier, true);
            $medianFrigate = MedianController::getTierMedian($tier, false);

            $atLoCruiser = MedianController::getLootAtThreshold($tier, 20, true);
            $atHiCruiser = MedianController::getLootAtThreshold($tier, 80, true);

            $atLoFrigate = MedianController::getLootAtThreshold($tier, 20, false);
            $atHiFrigate = MedianController::getLootAtThreshold($tier, 80, false);


            $lootTypesChart = new LootTypesChart();
            $lootTypesChart->load(route("chart.home.type.tier", ["tier" => $tier]));
            $lootTypesChart->displayAxes(false);
            $lootTypesChart->displayLegend(false);
            $lootTypesChart->export(true, "Download");
            $lootTypesChart->height("300");
            $lootTypesChart->theme(ThemeController::getChartTheme());


            $survivalChart = new SurvivalLevelChart();
            $survivalChart->load(route("chart.home.survival.tier", ["tier" => $tier]));
            $survivalChart->displayAxes(false);
            $survivalChart->displayLegend(false);
            $survivalChart->export(true, "Download");
            $survivalChart->height("300");
            $survivalChart->theme(ThemeController::getChartTheme());


            $popularFits = Cache::remember("aft.infopage.tier.$tier.fits", now()->addMinutes(15), function() use ($tier) {
                $query = $this->fitSearchController->getStartingQuery()
                                                   ->whereRaw("(
            (
	fit_recommendations.DARK		 = $tier AND
	fit_recommendations.ELECTRICAL	<= $tier AND
	fit_recommendations.EXOTIC		<= $tier AND
	fit_recommendations.FIRESTORM	<= $tier AND
	fit_recommendations.GAMMA		<= $tier
)
OR
(
	fit_recommendations.DARK		<= $tier AND
	fit_recommendations.ELECTRICAL	 = $tier AND
	fit_recommendations.EXOTIC		<= $tier AND
	fit_recommendations.FIRESTORM	<= $tier AND
	fit_recommendations.GAMMA		<= $tier
)
OR
(
	fit_recommendations.DARK		<= $tier AND
	fit_recommendations.ELECTRICAL	<= $tier AND
	fit_recommendations.EXOTIC		 = $tier AND
	fit_recommendations.FIRESTORM	<= $tier AND
	fit_recommendations.GAMMA		<= $tier
)
OR
(
	fit_recommendations.DARK		<= $tier AND
	fit_recommendations.ELECTRICAL	<= $tier AND
	fit_recommendations.EXOTIC		<= $tier AND
	fit_recommendations.FIRESTORM	 = $tier AND
	fit_recommendations.GAMMA		<= $tier
)
OR
(
	fit_recommendations.DARK		<= $tier AND
	fit_recommendations.ELECTRICAL	<= $tier AND
	fit_recommendations.EXOTIC		<= $tier AND
	fit_recommendations.FIRESTORM	<= $tier AND
	fit_recommendations.GAMMA		 = $tier
)
)")
                                                   ->limit(7)
                                                   ->orderByDesc("RUNS_COUNT");
                $popularFits = $query->get();
                foreach ($popularFits as $i => $result) {
                    $popularFits[$i]->TAGS = $this->fitSearchController->getFitTags($result->ID);
                }

                return $popularFits;
            });

            $runs =  DB::table("v_runall")->orderBy("CREATED_AT", "DESC")->where("TIER", $tier)->limit(20)->get();
            $drops = DB::select("SELECT          ip.ITEM_ID,
                MAX(ip.PRICE_BUY) as PRICE_BUY,
                MAX(ip.PRICE_SELL) as PRICE_SELL,
                MAX(ip.NAME) as NAME,
                MAX(ip.GROUP_NAME) as GROUP_NAME,
  (SELECT SUM(drci.DROPPED_COUNT)/SUM(drci.RUNS_COUNT)
   FROM droprates_cache drci
   WHERE drci.ITEM_ID=ip.ITEM_ID
     AND drci.TIER=?
     AND drci.TYPE='All') DROP_CHANCE
FROM item_prices ip
LEFT JOIN droprates_cache drc ON ip.ITEM_ID=drc.ITEM_ID
WHERE drc.TYPE='ALL'
AND drc.TIER=?
GROUP BY ip.ITEM_ID
ORDER BY 6 DESC LIMIT ?;
", [$tier, $tier, 10]);

            $count = Cache::remember("aft.infopage.tier.$tier.count", now()->addMinutes(15), function() use ($tier) {
                return DB::table("runs")->where("TIER", $tier)->count();
            });


            $heroes = Cache::remember("aft.infopage.tier.$tier.people", now()->addMinutes(15), function() use ($tier) {
                return DB::table("runs")
                         ->where("runs.TIER", $tier)
                         ->where("runs.PUBLIC", true)
                         ->groupBy("runs.CHAR_ID")
                         ->groupBy("chars.NAME")
                         ->select(["runs.CHAR_ID", DB::raw("COUNT(runs.ID) as CNT"), "chars.NAME"])
                         ->orderBy('CNT', "DESC")
                         ->join("chars", "runs.CHAR_ID","=","chars.CHAR_ID")
                         ->limit(6)
                         ->get();
            });


            return view("infopages.infopage", [
                'medianCruiser' => $medianCruiser,
                'medianFrigate' => $medianFrigate,
                'atLoCruiser' => $atLoCruiser,
                'atHiCruiser' => $atHiCruiser,
                'atLoFrigate' => $atLoFrigate,
                'atHiFrigate' => $atHiFrigate,

                'chartTypes' => $lootTypesChart,
                'chartSurvival' => $survivalChart,
                'popularFits' => $popularFits,

                'runs' => $runs,
                'count' => $count,
                'drops'=> $drops,

                'heroes' => $heroes,

                'tier' => $tier
            ]);
	    }
	}
