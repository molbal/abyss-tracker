<?php


	namespace App\Http\Controllers;


	use DateTime;

    class TimeHelper {

        public static function timeElapsedString($datetime, $full = false) {
            if ($datetime == "never") return "never";
            $now = new DateTime;
            try {
                $ago = new DateTime($datetime);
            } catch (\Exception $e) {
                return "unknown time ago";
            }
            $diff = $now->diff($ago);

            $diff->w = floor($diff->d / 7);
            $diff->d -= $diff->w * 7;

            $string = array(
                'y' => 'year',
                'm' => 'month',
                'w' => 'week',
                'd' => 'day',
                'h' => 'hour',
                'i' => 'minute',
                's' => 'second',
            );
            foreach ($string as $k => &$v) {
                if ($diff->$k) {
                    $v = $diff->$k . ' ' . $v . ($diff->$k > 1 ? 's' : '');
                } else {
                    unset($string[$k]);
                }
            }

            if (!$full) $string = array_slice($string, 0, 1);
            $return = $string ? implode(', ', $string) . ' ago' : 'just now';

            if ($return == "1 day ago") {
                $return = "yesterday";
            }
            if ($return == "1 week ago") {
                $return = "last week";
            }
            return $return;
        }

        /**
         * @param int $seconds
         *
         * @return string
         */
        public static function formatSecondsToMMSS(int $seconds):string {
            return sprintf("%02d:%02d",$seconds/60,$seconds%60);
        }
	}
