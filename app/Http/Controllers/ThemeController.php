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
            return Cookie::has("dark-theme") && Cookie::get("dark-theme") == "true";
        }

        public static function getChartTheme():string {
            return self::isDarkTheme() ? 'dark' : 'light';
        }

        public static function getThemedIconColor():string {
            return self::isDarkTheme() ? "ffffff" : "000000";
        }

        public function setTheme(bool $isDark) {
            if ($isDark) {
                Cookie::queue("dark-theme", "true", time()+60*60*24*60);
            }
            else {
                Cookie::queue("dark-theme", "bright", time()+60*60*24*60);
                Cookie::forget("dark-theme");
            }
            return redirect(route("home"));
        }
    }
