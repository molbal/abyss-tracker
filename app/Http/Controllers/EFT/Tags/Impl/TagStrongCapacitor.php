<?php


	namespace App\Http\Controllers\EFT\Tags\Impl;


	use App\Http\Controllers\EFT\Tags\IFitTag;

    class TagStrongCapacitor implements IFitTag {

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
            return (stripos($this->eft, "Capacitor") !== false)
                || (stripos($this->eft, "Memory cell") !== false)
                || (stripos($this->eft, "Cap battery") !== false);
        }
	}
