<?php

namespace App\Charts;

use ConsoleTVs\Charts\Classes\Echarts\Chart;

class RunBetter extends Chart
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
//        dd($strict, $noBraces);
//        dd($this->options);
        $options =  parent::formatOptions($strict, $noBraces);


        // Workaround!
        $options = str_ireplace('"xAxis":{"data":[]}', '"xAxis":{}', $options);
        $options = str_ireplace('"yAxis":{"show":true}', '"yAxis":{"show":false}', $options);
        $options = str_ireplace('"formatter":"function(params) {return params.name;}"', '"formatter":function(params) {return params[0]["value"][0]+" M ISK";}', $options);

        return $options;
    }


}
