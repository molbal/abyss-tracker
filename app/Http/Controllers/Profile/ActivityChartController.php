<?php

namespace App\Http\Controllers\Profile;

use App\Charts\ActivityChart;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Controller;
use App\Http\Controllers\Misc\Enums\CharacterType;
use App\Http\Controllers\ThemeController;
use Illuminate\Http\Request;
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
     */
    public function redirectToYear(int $year) {
        if (self::getYears()->contains($year)) {
            session()->flash('home_year', $year);
        }
        return redirect(route('home_mine'));
    }

    /**
     * Returns allowed years
     * @return array
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
     * @throws \App\Exceptions\SecurityViolationException
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
}
