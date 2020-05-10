<?php


	namespace App\Http\Controllers\EFT\Tags\Impl;


	use App\Http\Controllers\EFT\Tags\IFitTag;

    class TagArmorActive  implements IFitTag {

        /** @var string */
        private $eft;
        /** @var array */
        private $stats;
        /**
         * TagAfterburner constructor.
         *
         * @param string $eft
         * @param array  $stats
         */
        public function __construct(string $eft, array $stats) {
            $this->eft = $eft;
            $this->stats = $stats;
        }


        public function calculate() : bool {
            return intval($this->stats["defense"]["burst"]["armor"]) > 0;
        }

	}
