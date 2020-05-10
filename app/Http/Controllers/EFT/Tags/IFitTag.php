<?php


	namespace App\Http\Controllers\EFT\Tags;


	interface IFitTag {
        /**
         * IFitTag constructor. Takes the EFT and the stats as constructor
         *
         * @param string $eft
         * @param array  $stats
         */
	    public function __construct(string $eft, array $stats);
        public function calculate(): bool;

	}
