<?php


	namespace App\Http\Controllers\EFT\DTO;


	use Illuminate\Support\Collection;

    class Eft {

	    /** @var Collection */
	    private $lines;

	    /** @var int */
	    private $shipId;

	    /** @var string */
	    private $fitName;

        /**
         * @return Collection
         */
        public function getLines() : Collection {
            return $this->lines;
        }

        /**
         * @param Collection $lines
         *
         * @return Eft
         */
        public function setLines(Collection $lines) : Eft {
            $this->lines = $lines;

            return $this;
        }

        /**
         * @return int
         */
        public function getShipId() : int {
            return $this->shipId;
        }

        /**
         * @param int $shipId
         *
         * @return Eft
         */
        public function setShipId(int $shipId) : Eft {
            $this->shipId = $shipId;

            return $this;
        }

        /**
         * @return string
         */
        public function getFitName() : string {
            return $this->fitName;
        }

        /**
         * @param string $fitName
         *
         * @return Eft
         */
        public function setFitName(string $fitName) : Eft {
            $this->fitName = $fitName;

            return $this;
        }



	}
