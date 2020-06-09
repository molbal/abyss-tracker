<?php


	namespace App\Http\Controllers\EFT\DTO;


	class EftLine {

	    private $typeId;

	    private $count;

	    private $ammoTypeId;

        /**
         * @return mixed
         */
        public function getTypeId() {
            return $this->typeId;
        }

        /**
         * @param mixed $typeId
         *
         * @return EftLine
         */
        public function setTypeId($typeId) {
            $this->typeId = $typeId;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getCount() {
            return $this->count;
        }

        /**
         * @param mixed $count
         *
         * @return EftLine
         */
        public function setCount($count) {
            $this->count = $count;

            return $this;
        }

        /**
         * @return mixed
         */
        public function getAmmoTypeId() {
            return $this->ammoTypeId;
        }

        /**
         * @param mixed $ammoTypeId
         *
         * @return EftLine
         */
        public function setAmmoTypeId($ammoTypeId) {
            $this->ammoTypeId = $ammoTypeId;

            return $this;
        }


	}
