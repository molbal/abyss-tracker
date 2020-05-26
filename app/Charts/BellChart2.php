<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Echarts\Chart;

class BellChart2 extends Chart
{
    /**
     * Initializes the chart.
     *
     * @param null $min
     * @param null $max
     */
    public function __construct($min =  null, $max = null) {

        $this->min = $min;
        $this->max = $max;

        parent::__construct();
    }

    public $min = null;
    public $max = null;


    public function formatOptions(bool $strict = false, bool $noBraces = false) {
        $options =  parent::formatOptions($strict, $noBraces);
        $extra = ",min:".$this->min??"'dataMin'".", max:".$this->max??"'dataMax'";
        // Workaround!
        $options = str_ireplace('"xAxis":{"data":[]}', '"xAxis":{type: \'value\''.$extra.', axisLabel: {formatter: \'{value} M ISK\'}}', $options);
        $options = str_ireplace('"yAxis":{"show":true}', '"yAxis":{"show":false}', $options);
        $options = str_ireplace('"formatter":"function(params) {return params.name;}"', '"formatter":function(params) {return params[0]["value"][0]+" M ISK";}', $options);

        return $options;
    }



}
