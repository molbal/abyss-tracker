<?php


    namespace App\Http;


    class KurtosisController {

        private $labels;
        private $values;

        private $type;
        private $tier;

        /**
         * KurtosisController constructor.
         *
         * @param $type
         * @param $tier
         */
        public function __construct($type, $tier) {
            $this->type = $type;
            $this->tier = $tier;
        }

        private function getGroupNum():int {
            switch ($this->tier) {
                case 1: return 200000;
                case 2: return 300000;
                case 3: return 2500000;
                case 4: return 4000000;
                case 5: return 6000000;
            }
        }

    }
