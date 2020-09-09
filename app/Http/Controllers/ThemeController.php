<?php


    namespace App\Http\Controllers;


    use Illuminate\Support\Facades\Cookie;
    use Symfony\Component\HttpFoundation\Cookie as SendCookie;

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

        public static function getThemedIconColor():string {
            return self::isDarkTheme() ? "ffffff" : "191d21";
        }
        public static function getThemedBorderColor():string {
            return self::isDarkTheme() ? "#191d21" : "#fff";
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
    }
