<?php


	namespace App\Http\Controllers;


	use Illuminate\Support\Facades\DB;

    class InfopageController extends Controller {

        /**
         * Handles the tier thing
         * @param int $tier
         *
         * @return array
         */
        public function tier(int $tier) {

            return view("infopages.infopage", [
                'tier' => $tier
            ]);
	    }
	}
