<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Echarts\Chart;

class MarketESIChart extends Chart
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

$options ="
    legend: {
            show: true
  },
  tooltip: {
            show: true,
    trigger: 'axis'
  },
  xAxis: {
            show: true,
    data: ".$this->formatLabels()."
  },
  yAxis: [
        {
            type: 'value',
            name: 'Item price',
            axisLabel: {
            formatter: '{value} ISK'
            }
        },
        {
            type: 'value',
            name: 'Traded daily volume',
            axisLabel: {
            formatter: '{value} vol.'
            }
        }
    ],
  toolbox: {
            show: true,
    feature: {
                saveAsImage: {
                    title: 'Download'
      }
    }
    }";

        return $options;
    }
}
