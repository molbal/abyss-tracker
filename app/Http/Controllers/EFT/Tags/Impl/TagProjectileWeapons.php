<?php


	namespace App\Http\Controllers\EFT\Tags\Impl;


	use App\Http\Controllers\EFT\Tags\IFitTag;

    class TagProjectileWeapons implements IFitTag {

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
            return (stripos($this->eft, "AutoCannon") !== false)
                || (stripos($this->eft, "Automatic Cannon ") !== false)
                || (stripos($this->eft, "Machine Gun") !== false)
                || (stripos($this->eft, "Repeating Cannon") !== false)
                || (stripos($this->eft, "Artillery") !== false)
                || (stripos($this->eft, "Howitzer") !== false);
        }

	}
