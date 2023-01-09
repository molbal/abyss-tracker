<?php


	namespace App\Http\Controllers;


	use App\Charts\CruiserChart;
    use App\Charts\DestroyerChart;
    use App\Charts\FrigateChart;
    use App\Charts\LootTypesChart;
    use App\Charts\SurvivalLevelChart;
    use App\Http\Controllers\DS\HistoricLootController;
    use App\Http\Controllers\DS\MedianController;
    use App\Http\Controllers\Misc\Enums\ShipHullSize;
    use App\Models\Run;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Validator;

    class InfopageController extends Controller {

        /** @var FitSearchController */
        private $fitSearchController;

        /** @var HistoricLootController */
        private $historicLootController;

        /** @var ItemController */
        private $itemController;

        /**
         * InfopageController constructor.
         *
         * @param FitSearchController    $fitSearchController
         * @param HistoricLootController $historicLootController
         * @param ItemController         $itemController
         */
        public function __construct(FitSearchController $fitSearchController, HistoricLootController $historicLootController, ItemController $itemController) {
            $this->fitSearchController = $fitSearchController;
            $this->historicLootController = $historicLootController;
            $this->itemController = $itemController;
        }


        public function tierType(int $tier, string $type) {

            set_time_limit(600);

            clock()->event("Input validation", "")->begin();
            $type = ucfirst(strtolower($type));
            Validator::make(['tier' => $tier, 'type' => $type], [
                'tier'  => 'required|numeric|exists:tier,TIER',
                'type' => 'required|exists:type,TYPE'
            ])->validate();
            clock()->event("Input validation", "")->end();

            clock()->event("Getting labels", "")->begin();
            $labels = $this->historicLootController->getLabel();
            clock()->event("Getting labels", "")->end();
            clock()->event("Initializing  labels", "")->begin();
            $cc = new CruiserChart();
            $cc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => $type, 'hullSize' => ShipHullSize::CRUISER]));
            $cc->displayAxes(true);
            $cc->displayLegend(true);
            $cc->export(true, "Download");
            $cc->height("300");
            $cc->theme(ThemeController::getChartTheme());
            $cc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $cc->labels($labels);

            $dc = new DestroyerChart();
            $dc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => $type, 'hullSize' => ShipHullSize::DESTROYER]));
            $dc->displayAxes(true);
            $dc->displayLegend(true);
            $dc->export(true, "Download");
            $dc->height("300");
            $dc->theme(ThemeController::getChartTheme());
            $dc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $dc->labels($labels);

            $fc = new FrigateChart();
            $fc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => $type, 'hullSize' => ShipHullSize::FRIGATE]));
            $fc->displayAxes(true);
            $fc->displayLegend(true);
            $fc->export(true, "Download");
            $fc->height("300");
            $fc->theme(ThemeController::getChartTheme());
            $fc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $fc->labels($labels);
            clock()->event("Initializing  labels", "")->end();

            clock()->event("Getting last 20 runs", "")->begin();
            $runs =  DB::table("v_runall")->orderBy("CREATED_AT", "DESC")->where("TIER", strval($tier))->where('TYPE', $type)->limit(20)->get();
            clock()->event("Getting last 20 runs", "")->end();
            clock()->event("Getting last drops", "")->begin();
            $drops = DB::select("SELECT          ip.ITEM_ID,
                MAX(ip.PRICE_BUY) as PRICE_BUY,
                MAX(ip.PRICE_SELL) as PRICE_SELL,
                MAX(ip.NAME) as NAME,
                MAX(ip.GROUP_NAME) as GROUP_NAME,
  (SELECT SUM(drci.DROPPED_COUNT)/SUM(drci.RUNS_COUNT)
   FROM droprates_cache drci
   WHERE drci.ITEM_ID=ip.ITEM_ID
     AND drci.TIER=?
     AND drci.TYPE=?) DROP_CHANCE
FROM item_prices ip
LEFT JOIN droprates_cache drc ON ip.ITEM_ID=drc.ITEM_ID
WHERE drc.TIER=?
AND drc.TYPE=?
GROUP BY ip.ITEM_ID
ORDER BY 6 DESC LIMIT ?;
", [$tier, $type, $tier,$type, 10]);
clock()->event("Getting last drops", "")->end();

            clock()->event("Getting top players (through cache)", "")->begin();
            $heroes = Cache::remember("aft.infopage.tier.$tier.$type.people", now()->addMinutes(15), function() use ($tier, $type) {
                clock()->event("Getting top players (DB access)", "")->begin();
                $v = DB::table("runs")
                         ->where("runs.TIER", strval($tier))
                         ->where("runs.TYPE", $type)
                         ->where("runs.PUBLIC", true)
                         ->groupBy("runs.CHAR_ID")
                         ->groupBy("chars.NAME")
                         ->select(["runs.CHAR_ID", DB::raw("COUNT(runs.ID) as CNT"), "chars.NAME"])
                         ->orderBy('CNT', "DESC")
                         ->join("chars", "runs.CHAR_ID","=","chars.CHAR_ID")
                         ->limit(6)
                         ->get();
                clock()->event("Getting top players (DB access)", "")->end();
                return $v;
            });

            clock()->event("Getting top players (through cache)", "")->end();

            clock()->event("Getting median values (through cache)", "")->begin();
            [$medianCruiser, $medianDestroyer, $medianFrigate, $atLoCruiser, $atHiCruiser, $atLoDestroyer, $atHiDestroyer, $atLoFrigate, $atHiFrigate] = Cache::remember('ao.runs.'.$tier.'.'.$type, now()->addMinutes(30), function () use ($tier, $type) {

                clock()->event("Calculating medianCruiser")->begin();
                $medianCruiser = MedianController::getTierTypeMedian($tier,$type, ShipHullSize::CRUISER);
                clock()->event("Calculating medianCruiser")->end();
                clock()->event("Calculating medianDestroyer")->begin();
                $medianDestroyer = MedianController::getTierTypeMedian($tier,$type, ShipHullSize::DESTROYER);
                clock()->event("Calculating medianDestroyer")->end();
                clock()->event("Calculating medianFrigate")->begin();
                $medianFrigate = MedianController::getTierTypeMedian($tier,$type, ShipHullSize::FRIGATE);
                clock()->event("Calculating medianFrigate")->end();
                clock()->event("Calculating atLoCruiser")->begin();
                $atLoCruiser = MedianController::getLootAtThresholdWeather($tier,$type, 20, ShipHullSize::CRUISER);
                clock()->event("Calculating atLoCruiser")->end();
                clock()->event("Calculating atHiCruiser")->begin();
                $atHiCruiser = MedianController::getLootAtThresholdWeather($tier, $type,80, ShipHullSize::CRUISER);
                clock()->event("Calculating atHiCruiser")->end();
                clock()->event("Calculating atLoDestroyer")->begin();
                $atLoDestroyer = MedianController::getLootAtThresholdWeather($tier,$type, 20, ShipHullSize::DESTROYER);
                clock()->event("Calculating atLoDestroyer")->end();
                clock()->event("Calculating atHiDestroyer")->begin();
                $atHiDestroyer = MedianController::getLootAtThresholdWeather($tier,$type, 80, ShipHullSize::DESTROYER);
                clock()->event("Calculating atHiDestroyer")->end();
                clock()->event("Calculating atLoFrigate")->begin();
                $atLoFrigate = MedianController::getLootAtThresholdWeather($tier,$type, 20, ShipHullSize::FRIGATE);
                clock()->event("Calculating atLoFrigate")->end();
                clock()->event("Calculating atHiFrigate")->begin();
                $atHiFrigate = MedianController::getLootAtThresholdWeather($tier,$type, 80, ShipHullSize::FRIGATE);
                clock()->event("Calculating atHiFrigate")->end();

                return [$medianCruiser, $medianDestroyer, $medianFrigate, $atLoCruiser, $atHiCruiser, $atLoDestroyer, $atHiDestroyer, $atLoFrigate, $atHiFrigate];
            });
            clock()->event("Getting median values (through cache)", "")->end();

            clock()->event('Getting most used fits (through cache)')->begin();
            $popularFits = Cache::remember("aft.infopage.tier.$tier.$type.fits", now()->addMinutes(15), function() use ($tier, $type) {

                clock()->event('Getting most used fits (DB access)')->begin();
                $query = $this->fitSearchController->getStartingQuery()->where('fit_recommendations.'.strtoupper($type), DB::raw("'".$tier."'"))->limit(7)->orderByDesc("RUNS_COUNT");
                $popularFits = $query->get();
                clock()->event('Getting most used fits (DB access)')->end();
                clock()->event('Populating fit tags')->begin();
                foreach ($popularFits as $i => $result) {
                    $popularFits[$i]->TAGS = $this->fitSearchController->getFitTags($result->ID);
                }
                clock()->event('Populating fit tags')->end();

                return $popularFits;
            });
            clock()->event('Getting most used fits (through cache)')->end();


            clock()->event('Getting runs count (through cache)')->begin();
            $count = Cache::remember('at.runs.count.'.$tier.'.'.$type, now()->addMinutes(30), function () use ($type,$tier) {
                return Run::where('TIER', DB::raw("'".$tier."'"))->where('TYPE', $type)->count();
            });
            clock()->event('Getting runs count (through cache)')->end();

//            DB::enableQueryLog();
            clock()->event('Getting filament ID and name')->begin();
            $filamentId = DB::table('filament_types')->where('TYPE', $type)->where('TIER', DB::raw("'".$tier."'"))->first('ITEM_ID')->ITEM_ID ?? 0;
            $filamentName = DB::table('item_prices')->where('ITEM_ID', $filamentId)->first('NAME')->NAME ?? "";
            clock()->event('Getting filament ID and name')->end();
//            dd(DB::getQueryLog());
            clock()->event('Getting item market historyope')->begin();
            $filamentChart = $this->itemController->itemMarketHistoryChart($filamentId);
            clock()->event('Getting item market historyope')->end();




            return view('infopages.weather', [
                'tier' => $tier,
                'type' => $type,

                'medianCruiser' => $medianCruiser,
                'medianFrigate' => $medianFrigate,
                'medianDestroyer' => $medianDestroyer,

                'atLoCruiser' => $atLoCruiser,
                'atHiCruiser' => $atHiCruiser,

                'atLoFrigate' => $atLoFrigate,
                'atHiFrigate' => $atHiFrigate,

                'atLoDestroyer' => $atLoDestroyer,
                'atHiDestroyer' => $atHiDestroyer,

                'count' => $count,
                'cruiserChart' => $cc,
                'destroyerChart' => $dc,
                'frigateChart' => $fc,

                'runs' => $runs,
                'drops'=> $drops,
                'heroes' => $heroes,

                'popularFits' => $popularFits,

                'filamentId' => $filamentId,
                'filamentName' => $filamentName,
                'filamentChart' => $filamentChart,
            ]);
        }


        /**
         * Handles the tier thing
         * @param int $tier
         *
         * @return array
         */
        public function tier(int $tier) {

            $medianCruiser = MedianController::getTierMedian($tier, ShipHullSize::CRUISER);
            $medianDestroyer = MedianController::getTierMedian($tier, ShipHullSize::DESTROYER);
            $medianFrigate = MedianController::getTierMedian($tier, ShipHullSize::FRIGATE);

            $atLoCruiser = MedianController::getLootAtThreshold($tier, 20, ShipHullSize::CRUISER);
            $atHiCruiser = MedianController::getLootAtThreshold($tier, 80, ShipHullSize::CRUISER);

            $atLoDestroyer = MedianController::getLootAtThreshold($tier, 20, ShipHullSize::DESTROYER);
            $atHiDestroyer = MedianController::getLootAtThreshold($tier, 80, ShipHullSize::DESTROYER);

            $atLoFrigate = MedianController::getLootAtThreshold($tier, 20, ShipHullSize::FRIGATE);
            $atHiFrigate = MedianController::getLootAtThreshold($tier, 80, ShipHullSize::FRIGATE);


            $labels = $this->historicLootController->getLabel();

            $cc = new CruiserChart();
            $cc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => '%', 'hullSize' => ShipHullSize::CRUISER]));
            $cc->displayAxes(true);
            $cc->displayLegend(true);
            $cc->export(true, "Download");
            $cc->height("300");
            $cc->theme(ThemeController::getChartTheme());
            $cc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $cc->labels($labels);

            $dc = new DestroyerChart();
            $dc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => '%', 'hullSize' => ShipHullSize::DESTROYER]));
            $dc->displayAxes(true);
            $dc->displayLegend(true);
            $dc->export(true, "Download");
            $dc->height("300");
            $dc->theme(ThemeController::getChartTheme());
            $dc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $dc->labels($labels);

            $fc = new FrigateChart();
            $fc->load(route('infopage.weather.chart', ['tier' => $tier, 'type' => '%', 'hullSize' => ShipHullSize::FRIGATE]));
            $fc->displayAxes(true);
            $fc->displayLegend(true);
            $fc->export(true, "Download");
            $fc->height("300");
            $fc->theme(ThemeController::getChartTheme());
            $fc->options([
                'tooltip' => [
                    'trigger' => "axis"
                ],
                'yAxis' =>  [
                    'axisLabel' => [
                        'formatter' => '{value} ISK'
                    ]
                ]
            ]);
            $fc->labels($labels);

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
	fit_recommendations.DARK		 = '$tier' AND
	fit_recommendations.ELECTRICAL	<= '$tier' AND
	fit_recommendations.EXOTIC		<= '$tier' AND
	fit_recommendations.FIRESTORM	<= '$tier' AND
	fit_recommendations.GAMMA		<= '$tier'
)
OR
(
	fit_recommendations.DARK		<= '$tier' AND
	fit_recommendations.ELECTRICAL	 = '$tier' AND
	fit_recommendations.EXOTIC		<= '$tier' AND
	fit_recommendations.FIRESTORM	<= '$tier' AND
	fit_recommendations.GAMMA		<= '$tier'
)
OR
(
	fit_recommendations.DARK		<= '$tier' AND
	fit_recommendations.ELECTRICAL	<= '$tier' AND
	fit_recommendations.EXOTIC		 = '$tier' AND
	fit_recommendations.FIRESTORM	<= '$tier' AND
	fit_recommendations.GAMMA		<= '$tier'
)
OR
(
	fit_recommendations.DARK		<= '$tier' AND
	fit_recommendations.ELECTRICAL	<= '$tier' AND
	fit_recommendations.EXOTIC		<= '$tier' AND
	fit_recommendations.FIRESTORM	 = '$tier' AND
	fit_recommendations.GAMMA		<= '$tier'
)
OR
(
	fit_recommendations.DARK		<= '$tier' AND
	fit_recommendations.ELECTRICAL	<= '$tier' AND
	fit_recommendations.EXOTIC		<= '$tier' AND
	fit_recommendations.FIRESTORM	<= '$tier' AND
	fit_recommendations.GAMMA		 = '$tier'
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

            $runs =  DB::table("v_runall")->orderBy("CREATED_AT", "DESC")->where("TIER", strval($tier))->limit(20)->get();
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
                return DB::table("runs")->where("TIER", DB::raw("'".$tier."'"))->count();
            });


            $heroes = Cache::remember("aft.infopage.tier.$tier.people", now()->addMinutes(15), function() use ($tier) {
                return DB::table("runs")
                         ->where("runs.TIER", strval($tier))
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
                'medianDestroyer' => $medianDestroyer,

                'atLoCruiser' => $atLoCruiser,
                'atHiCruiser' => $atHiCruiser,

                'atLoFrigate' => $atLoFrigate,
                'atHiFrigate' => $atHiFrigate,

                'atLoDestroyer' => $atLoDestroyer,
                'atHiDestroyer' => $atHiDestroyer,

                'chartTypes' => $lootTypesChart,
                'chartSurvival' => $survivalChart,
                'popularFits' => $popularFits,

                'runs' => $runs,
                'count' => $count,
                'drops'=> $drops,


                'cruiserChart' => $cc,
                'destroyerChart' => $dc,
                'frigateChart' => $fc,


                'heroes' => $heroes,

                'tier' => $tier
            ]);
	    }
	}
