<?php


	namespace App\Http\Controllers;


	class InfopageController extends Controller {

        /**
         * Handles the tier thing
         * @param int $tier
         *
         * @return array
         */
        public function tier(int $tier) {
            return ["yo" => $tier];
	    }
	}
