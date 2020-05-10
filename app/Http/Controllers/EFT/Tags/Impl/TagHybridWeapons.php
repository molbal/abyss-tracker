<?php


	namespace App\Http\Controllers\EFT\Tags\Impl;

	use App\Http\Controllers\EFT\Tags\IFitTag;

    class TagHybridWeapons  implements IFitTag {

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
            return (stripos($this->eft, "Railgun") !== false)
                || (stripos($this->eft, "Gauss Gun") !== false)
                || (stripos($this->eft, "Accelerator Cannon") !== false)
                || (stripos($this->eft, "Blaster") !== false)
                || (stripos($this->eft, "Particle Cannon") !== false)
                || (stripos($this->eft, "Particle Accelerator") !== false)
                || (stripos($this->eft, "POhase Cannon") !== false);
        }

	}
