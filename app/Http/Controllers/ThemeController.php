<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\Misc\Enums\ChartColor;
    use Illuminate\Support\Facades\Cookie;
    use Illuminate\Support\Str;

    class ThemeController extends Controller {

        /**
         * Checks if you have dark theme enabled
         * @return bool
         */
        public static function isDarkTheme():bool {
            $cached = config("runtime.theme.dark", null);
            if ($cached == null) {
                $val = !(Cookie::get("bright-theme", "false") == "true");
                config(["runtime.theme.dark" => $val]);
                return $val;
            }
            return $cached;
        }

        public static function getChartTheme():string {
            return self::isDarkTheme() ? 'dark' : 'walden';
        }

        public static function getThemedIconColor(bool $addHash = false):string {
            return ($addHash ? '#' : '') . (self::isDarkTheme() ? "ffffff" : "191d21");
        }
        public static function getThemedBorderColor(bool $addHash = false):string {
            return ($addHash ? '#' : '') . (self::isDarkTheme() ? "#191d21" : "#fff");
        }

        public static function getActivityChartColors() {
            return (self::isDarkTheme() ? ['#161b22','#003820','#00602d','#00602d','#27d545'] : ['#ebedf0','#9be9a8','#40c463','#40c463','#216e39']);
        }
        public static function getShipSizeIconPath(string $class):string {
            return "_icons/ship-class/" . (self::isDarkTheme() ? "ffffff" : "000000") ."/".$class."_64.png";
        }

        public static function getThemedNavBarIconColor(bool $active):string {
            if ($active) {
                return self::isDarkTheme() ? "ffffff" : "e3342f";
            }
            else {
                return self::isDarkTheme() ? "eeeeee" : "9ba6b2";
            }
        }

        public static function getLoader(string $size = "lg") {

        }

        public static function getChartLineColor(string $color) : string {
            switch ($color) {
                case ChartColor::GREEN: return self::isDarkTheme() ? '#38c172' : '#38c172';
                case ChartColor::GRAY:  return self::isDarkTheme() ? '#6c757d' : '#6c757d';
                case ChartColor::RED:   return self::isDarkTheme() ? '#e3342f' : '#e3342f';
                case ChartColor::BLUE:  return self::isDarkTheme() ? '#397bb0' : '#397bb0';
            }
            return '#fff';
        }

		 public static function getDangerColor(bool $addHash = false): string {
            $c = self::getChartLineColor(ChartColor::RED);
            return  $addHash ? $c : Str::of($c)->remove("#");
		 }


		 public function setTheme(bool $isDark) {
            if ($isDark) {
                Cookie::queue("bright-theme", "false", time()+60*60*24*60);
                Cookie::forget("bright-theme");
            }
            else {
                Cookie::queue("bright-theme", "true", time()+60*60*24*60);
            }
            return redirect(url()->previous(route("home")));
        }

        public static function getGlitchIcon() {
            return asset(sprintf("_icons/glitch-%s.gif", self::isDarkTheme() ? "dark" : "light"));
        }
    }
