<?php


	namespace App\Http\Controllers\DS;


    use App\Http\Controllers\HelperController;
    use App\Http\Controllers\TimeHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;


	class FitAdvancedStatsCalculator {
        /**
        * Generates stats for a given fit_id
         *
         * @param int $fit_id The fit_id to generate stats for
         *
         * @return array An array of stats for the given fit_id
        */

        public static function generate($fit_id) {

            try {
                $_data = DB::select("select * from runs where fit_id = ? and created_at > DATE_SUB(NOW(),INTERVAL 1 YEAR) and RUNTIME_SECONDS is not null and RUNTIME_SECONDS > 0 order by tier desc,type asc",[$fit_id]);

                //organize
                $data = [];
                foreach ( $_data as $d ) {
                    $data[$d->TYPE."-".$d->TIER][] = $d;
                }

                //tt type tier
                $stats = [];
                foreach( $data as $index => $tt ) {
                    $tmp = new \stdClass();
                    $run_count = 0;
                    $total = 0;
                    $time = 0;
                    foreach($tt as $run){
                        $run_count++;
                        $total += $run->LOOT_ISK;
                        $time += $run->RUNTIME_SECONDS;
                    }
                    $tmp->TYPE = $run->TYPE;
                    $tmp->TIER = $run->TIER;
                    $tmp->TOTAL = $total;
                    $tmp->COUNT = $run_count;
                    $tmp->AVERAGE_ISK = $total/$run_count;
                    $tmp->AVERAGE_TIME = $time/$run_count;
                    $tmp->AVERAGE_ISK_BY_HR = ($tmp->AVERAGE_ISK/$tmp->AVERAGE_TIME)*60*60;
                    $tmp->AVERAGE_DISPLAY = number_format($tmp->AVERAGE_ISK/1000000,2,","," ");
                    $tmp->AVERAGE_TIME_DISPLAY = number_format($tmp->AVERAGE_TIME,0);
                    $tmp->AVERAGE_ISK_BY_HR_DISPLAY = number_format($tmp->AVERAGE_ISK_BY_HR/1000000,2,","," ");

                    $stats[$index] = $tmp;
                }

                //cut out 80% type runs
                if ( !!$stats ) {
                    foreach( $data as $index => $tt ) {
                        $info = $stats[$index];
                        self::calculate_threshold($info,$tt,.8);
                    }
                }
            } catch (\Error $e) {
                $stats = [];
            }


            return $stats;
        }
        /**
        * Calculate the threshold for a given set of data.
         * 
         * @param object $info The information to be used for the calculation.
         * @param array $tt The array of runs to be used for the calculation.
         * @param float $percent The percentage of the threshold to be calculated.
         * 
         * @return void
        */

        private static function calculate_threshold($info,$tt,$percent) {
            $__ISK = $info->AVERAGE_ISK * 2 * (1-$percent);
            $__TIME = $info->AVERAGE_TIME * 2 * (1-$percent);
            $display = $percent*100;
            $run_count = 0;
            $total = 0;
            $time = 0;
            foreach($tt as $run){

                if ( $run->LOOT_ISK > $__ISK
                    && $run->LOOT_ISK < ($info->AVERAGE_ISK*2-$__ISK)
                    && $run->RUNTIME_SECONDS > $__TIME
                    && $run->RUNTIME_SECONDS < ($info->AVERAGE_TIME*2-$__TIME)
                ) {
                    $run_count++;
                    $total += $run->LOOT_ISK;
                    $time += $run->RUNTIME_SECONDS;
                }
            }

            try {
                $info->{'COUNT_'.$display} = $run_count;
                $info->{'TOTAL_'.$display} = $total;
                $info->{'AVERAGE_ISK_'.$display} = $total/$run_count;
                $info->{'AVERAGE_TIME_'.$display} = $time/$run_count;
                $info->{'AVERAGE_ISK_BY_HR_'.$display} = ($info->{'AVERAGE_ISK_'.$display}/$info->{'AVERAGE_TIME_'.$display})*60*60;
                $info->{'AVERAGE_DISPLAY_'.$display} = number_format( $info->{'AVERAGE_ISK_'.$display}/1000000,2,","," ");
                $info->{'AVERAGE_TIME_DISPLAY_'.$display} = number_format( $info->{'AVERAGE_TIME_'.$display},0);
                $info->{'AVERAGE_ISK_BY_HR_DISPLAY_'.$display} = number_format( $info->{'AVERAGE_ISK_BY_HR_'.$display}/1000000,2,","," ");
            } catch (\Error $e) {
                $info->{'COUNT_'.$display} = 0;
                $info->{'TOTAL_'.$display} = 0;
                $info->{'AVERAGE_ISK_'.$display} = 0;
                $info->{'AVERAGE_TIME_'.$display} = 0;
                $info->{'AVERAGE_ISK_BY_HR_'.$display} = 0;
                $info->{'AVERAGE_DISPLAY_'.$display} = 0;
                $info->{'AVERAGE_TIME_DISPLAY_'.$display} = 0;
                $info->{'AVERAGE_ISK_BY_HR_DISPLAY_'.$display} = 0;
            }
        }
        /**
        * Function to echo out the given argument
         * 
         * @return void
        */

        public static function echo_me() {
            echo "<pre>";
            foreach ( func_get_args() as $something ){
                echo "DEBUG ->";
                print_r($something);
                echo "<br><br>";
            }
            echo "</pre>";
        }
	}
