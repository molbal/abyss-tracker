<?php

namespace App\Http\Controllers\Profile;

use App\Charts\ActivityChart;
use App\Charts\TimelineChart;
use App\Exceptions\SecurityViolationException;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Misc\Enums\CharacterType;
use App\Http\Controllers\ThemeController;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Http\RedirectResponse;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ActivityChartController extends Controller {

    public static function getChartContainer(int $year):ActivityChart {

        $chart = new ActivityChart();
//        $chart->export(true, "Download");
        $chart->displayAxes(false);
        $chart->height(200);
        $chart->theme(ThemeController::getChartTheme());
        $chart->displayLegend(false);
        $chart->options([
            'visualMap' => [
                'show' => false,
                'min' => 0,
                'max' => 10,
                'inRange' => [
                    'color' => ThemeController::getActivityChartColors(),
                    'symbolSize' => [100,100],
                ],
                'shadowColor' => 'rgba(0, 0, 0, 0.5)',
                'shadowBlur' => 10,
                'shadowOffsetX' => 0,
                'shadowOffsetY' => 40,
                'textStyle' => [
                    'fontFamily' => 'Shentox 13'
                ]
            ],
            'calendar' => [
                'left' => 50,
                'top' =>20,
                'right' => 10,
                'range' => $year,
                'itemStyle' => [
                    'color' => 'rgba(0,0,0,0)',
                    'borderWidth' => 4,
                    'borderColor' => 'rgba(0,0,0,0)',
                    'shadowColor' => 'rgba(0, 0, 0, 0.1)',
                    'shadowBlur' => 5,
                ],
                'dayLabel' => [
                    'firstDay' => 1,
                    'color' => ThemeController::getThemedIconColor(true),
                    'fontFamily' => '"Shentox 13"'
                ],
                'monthLabel' => [
                    'color' => ThemeController::getThemedIconColor(true),
                    'fontFamily' => '"Shentox 13"'
                ],
                'yearLabel' => [
                    'fontFamily' => '"Shentox 13"'
                ],
                'splitLine' => [
                    'show' => false,
                ]
            ]
        ]);
        $chart->load(route('chart.activity', ['year' => $year]));
        return $chart;
    }

    /**
     * @param int $year
     *
     * @return Application|RedirectResponse|Redirector
     */
    public function redirectToYear(int $year) {
        if (self::getYears()->contains($year)) {
            session()->flash('home_year', $year);
        }
        return redirect(route('home_mine'));
    }

    /**
     * Returns allowed years
     *
     * @return Collection
     */
    public static function getYears(): Collection {
        return Cache::remember('activity-graph.years', now()->addHours(4), function () {
           return collect(DB::select("select year(d.day) year from date_helper d where d.day <= now() and d.day >= '2020-12-31' group by year(d.day) order by 1;"))->pluck('year');
        });
    }

    /**
     * Handles loading the chart
     * @param int $year
     *
     * @return string
     * @throws SecurityViolationException
     */
    public function loadChart(int $year) {

        if (AltRelationController::getCharacterType() == CharacterType::MAIN) {
            $charIds = AltRelationController::getAllMyAvailableCharacters(false);
        }
        else {
            $charIds = collect([['id' => AuthController::getLoginId()]]);
        }

        $q = collect(DB::select('select d.day, count(r.id) as count from date_helper d left join runs r on d.day=r.RUN_DATE and r.CHAR_ID in ('.$charIds->pluck('id')->implode(',').') where  year(d.day)=? group by d.day order by d.day asc;', [$year]));

        $data = $q->map(function ($raw) {
            return [$raw->day, $raw->count];
        });

        $chart = new ActivityChart();
        $chart->dataset('Daily runs', 'heatmap', $data)->options(
            ['coordinateSystem'=> 'calendar']);
        return $chart->api();
    }

    /**
     * @param int $charId
     *
     * @return TimelineChart
     */
    public static function getTimelineContainer(int $charId): TimelineChart {

        $chart = new TimelineChart();
        $chart->displayAxes(false);
        $chart->height(400);
        $chart->theme(ThemeController::getChartTheme());
        $chart->labels(collect(DB::table('date_helper')->whereRaw('day <= NOW()')->get(['day']))->pluck('day'));
        $chart->load(route('chart.timeline', ['char' => $charId]));
        return $chart;
    }

    /**
     * Loads data to getTimelineContainer's container
     * @param int $charId
     * @see getTimelineContainer
     *
     * @return string
     * @throws SecurityViolationException
     */
    public function loadTimelineChart(int $charId) {
        if(!AltRelationController::getAllMyAvailableCharacters(false)->contains('id', '=',$charId)) {
            throw new SecurityViolationException("");
        }

        $charIds = collect([['id' => AuthController::getLoginId(), 'name' => AuthController::getCharName()]]);

        $chart = new TimelineChart();
        foreach ($charIds as $charId) {
            $q  = collect(DB::select('select c.day, c.count, c.sum, c.all_seconds, ROUND(c.sum/greatest(c.all_seconds, 3600))*3600 isk_per_hour from (select d.day,
       count(r.id) count,
       sum(r.LOOT_ISK) sum,
       if(count(r.id)=0,0,sum(coalesce(r.RUNTIME_SECONDS, 20*60))) all_seconds

from date_helper d
         left join runs r on d.day = r.RUN_DATE and r.CHAR_ID in ('.$charId->id.')
group by d.day, r.char_id
order by d.day asc) c;'));


            $days = collect(DB::table('date_helper')->whereRaw('day <= NOW()')->get(['day']))->pluck('day');
            $iph = [];
            $cnt = [];
            foreach ($days as $day) {
                $iph[] = $q->firstWhere('day', $day)->isk_per_hour ?? 0;
                $cnt[] = $q->firstWhere('day', $day)->count ?? 0;
            }

            $chart->dataset("ISK/hour: ".$charId->name, 'bar', $iph)->options(['showSymbol'=> false]);
            $chart->dataset("Runs: ".$charId->name, 'bar', $cnt)->options(['showSymbol'=> false,
                    'yAxisIndex' => 1]);
        }
        return $chart->api();



    }
}
