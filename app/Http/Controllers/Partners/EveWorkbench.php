<?php


	namespace App\Http\Controllers\Partners;


	class EveWorkbench {

        /**
         * Gets the EVE Workbench URL
         * @param string $name
         *
         * @return string
         */
        public static function getProfileUrl(string $name): string {
            $name = preg_replace('/[^a-zA-Z0-9\' ]/', '', $name);
            $name = str_replace("'", '', $name);
            return "https://www.eveworkbench.com/u/".strtolower(str_replace(" ", "-", $name));
	    }
	}
