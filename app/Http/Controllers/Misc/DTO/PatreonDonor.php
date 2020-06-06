<?php


	namespace App\Http\Controllers\Misc\DTO;


	class PatreonDonor {

	    /** @var string */
	    public $name;

	    /** @var int */
	    public $patreonId;

	    /** @var float */
	    public $totalAmount;

	    /** @var boolean */
	    public $activePatron;

        /**
         * @return string
         */
        public function getName() : string {
            return $this->name;
        }

        /**
         * @param string $name
         *
         * @return PatreonDonor
         */
        public function setName(string $name) : PatreonDonor {
            $this->name = $name;

            return $this;
        }

        /**
         * @return int
         */
        public function getPatreonId() : int {
            return $this->patreonId;
        }

        /**
         * @param int $patreonId
         *
         * @return PatreonDonor
         */
        public function setPatreonId(int $patreonId) : PatreonDonor {
            $this->patreonId = $patreonId;

            return $this;
        }

        /**
         * @return float
         */
        public function getTotalAmount() : float {
            return $this->totalAmount;
        }

        /**
         * @param float $totalAmount
         *
         * @return PatreonDonor
         */
        public function setTotalAmount(float $totalAmount) : PatreonDonor {
            $this->totalAmount = $totalAmount;

            return $this;
        }

        /**
         * @return bool
         */
        public function isActivePatron() : bool {
            return $this->activePatron;
        }

        /**
         * @param bool $activePatron
         *
         * @return PatreonDonor
         */
        public function setActivePatron(bool $activePatron) : PatreonDonor {
            $this->activePatron = $activePatron;

            return $this;
        }

	}
