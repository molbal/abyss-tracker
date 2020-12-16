<?php

namespace App\Charts;

use App\Http\Controllers\ThemeController;
use ConsoleTVs\Charts\Classes\Echarts\Chart;

class DropHistoryChart extends Chart
{
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function formatOptions(bool $strict = false, bool $noBraces = false) {

        $options =  parent::formatOptions($strict, $noBraces);
$options .=",
    dataZoom: [{
        type: 'inside',
        start: 80,
        end: 100
    }, {
        start: 0,
        end: 10,
        handleIcon: 'M10.7,11.9v-1.3H9.3v1.3c-4.9,0.3-8.8,4.4-8.8,9.4c0,5,3.9,9.1,8.8,9.4v1.3h1.3v-1.3c4.9-0.3,8.8-4.4,8.8-9.4C19.5,16.3,15.6,12.2,10.7,11.9z M13.3,24.4H6.7V23h6.6V24.4z M13.3,19.6H6.7v-1.4h6.6V19.6z',
        handleSize: '80%',
        handleStyle: {
            color: '#".ThemeController::getThemedIconColor()."',
            shadowBlur: 3,
            shadowColor: 'rgba(0, 0, 0, 0.2)',
            shadowOffsetX: 0,
            shadowOffsetY: 2
        }
    }]";

        return $options;
    }
}
