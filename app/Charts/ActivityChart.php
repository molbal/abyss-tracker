<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Echarts\Chart;

class ActivityChart extends Chart {
    /**
     * Initializes the chart.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }


    public function formatOptions(bool $strict = false, bool $noBraces = false) {
        $options = parent::formatOptions($strict, $noBraces);

        $options  = str_ireplace('"tooltip":{"show":true},', "
    tooltip: {
        show: true,
        position: 'top',
        confine: true,
        formatter: function (p) {
            var format = echarts.format.formatTime('yyyy-MM-dd', p.data[0]);
            return 'Daily runs<br/>' +format + ': ' + p.data[1];
        }
    },", $options);
//        $options = str_ireplace("\"tooltip\":{\"position\":\"top\"},", "
//    tooltip: {
//        show: true,
//        position: 'top',
//        formatter: function (p) {
//            var format = echarts.format.formatTime('yyyy-MM-dd', p.data[0]);
//            return format + ': ' + p.data[1];
//        }
//    },", $options);

        return $options;
    }
}
