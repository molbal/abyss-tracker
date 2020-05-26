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
            return !(Cookie::has("bright-theme") && Cookie::get("bright-theme") == "true");
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
            return redirect(route("home"));
        }
    }
