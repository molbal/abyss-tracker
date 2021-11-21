<?php


	namespace App\Http\Controllers\DS;


	use App\Charts\ShipDpsDistribution;
    use App\Http\Controllers\ThemeController;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;

    class ShipStatsController {
        public static function getDpsChart(int $shipId, int $step = 25): ShipDpsDistribution {
            /** @var Collection $dataset */
            $dataset = \Cache::remember(sprintf("ship.%d.dps.%d", $shipId, $step), now()->addMinutes(30), function () use ($shipId, $step) {
               return collect(DB::select("
                    select floor(a.totaldps / $step) * $step as bin_floor, count(*) cnt
                    from (select cast(json_extract(STATS, '$.offense.totalDps') as decimal(5, 2)) as totaldps
                          from fits
                          where SHIP_ID = ?
                            and json_extract(STATS, '$.offense.totalDps') is not null
                            and cast(json_extract(STATS, '$.offense.totalDps') as decimal(5, 2)) > 0
                          order by 1) a
                    group by 1
                    order by 1
               ", [$shipId]));
            });
            $chart = new ShipDpsDistribution();
            $chart->height(400);
            $chart->export(true, "Download");
            $chart->theme(ThemeController::getChartTheme());
            $chart->labels($dataset->pluck('bin_floor')->map(fn ($bin_floor) => $bin_floor.' - '.($bin_floor+$step).' dps'));
            $chart->dataset('DPS distribution', 'bar', $dataset->pluck('cnt'));

            return  $chart;

        }
	}
