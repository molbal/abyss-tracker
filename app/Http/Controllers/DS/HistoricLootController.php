<?php


	namespace App\Http\Controllers\DS;


	use App\Charts\CruiserChart;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\Misc\Enums\ShipHullSize;
    use ConsoleTVs\Charts\Features\Echarts\Chart;
    use Illuminate\Support\Carbon;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Log;

    class HistoricLootController extends Controller {


        /**
         * @param int    $tier
         * @param string $type
         * @param string $hullSize
         *
         * @return string
         */
        public function getChartData(int $tier, string $type, string $hullSize) {

            return Cache::remember(sprintf('ao.char-weather-data.%d.%s.%s', $tier, $type, $hullSize), now()->addHours(12), function () use ($tier, $type, $hullSize) {
                /** @var CruiserChart $chart */
                $chart = resolve('App\Charts\\'.ucfirst($hullSize).'Chart');

                $data = $this->getForTierType($tier, $type, $hullSize);
                $chart->dataset("Median of 3 days", "line", $data->pluck('median3day'));
                $chart->dataset("Median of 7 days", "line", $data->pluck('median7day'));
                $chart->dataset("Median of 30 days", "line", $data->pluck('median30day'));

                return $chart->api();
            });
        }

        public function getLabel() {

            $startDate = new Carbon(config('tracker.historic-loot.from'));
            $dataset = collect([]);

            while (!$startDate->isToday()) {
                $startDate = $startDate->addDay();
                $dataset->add($startDate->toDateString());
            }

            return $dataset;
        }

        /**
         * @param int    $tier
         * @param string $type
         * @param string $hullSize
         *
         * @return \Illuminate\Support\Collection
         */
        protected function getForTierType(int $tier, string $type, string $hullSize) {

            $startDate = new Carbon(config('tracker.historic-loot.from'));
            $dataset = collect([]);

            while (!$startDate->isToday()) {

                ini_set('max_execution_time', 3600);
                set_time_limit(3600);
                $startDate = $startDate->addDay();
                $dataset->add([
                    'median3day' => MedianController::getLootForRange($tier, $type, 3, $startDate, $hullSize) ?? $dataset->last()['median3day'] ?? 0,
                    'median7day' => MedianController::getLootForRange($tier, $type, 7, $startDate, $hullSize) ?? $dataset->last()['median7day'] ?? 0,
                    'median30day' => MedianController::getLootForRange($tier, $type, 30, $startDate, $hullSize) ?? $dataset->last()['median30day'] ?? 0
                ]);

            }

            return $dataset;
	    }


	}
