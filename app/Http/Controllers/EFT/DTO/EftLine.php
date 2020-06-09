<?php


	namespace App\Http\Controllers\EFT\DTO;


	use Illuminate\Support\Facades\DB;

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

        /**
         * @param $dbLine
         *
         * @return EftLine
         */
        public static function fromDb($dbLine): EftLine {
            $line = new EftLine();
            $line->setTypeId($dbLine->ITEM_ID)
                ->setCount($dbLine->COUNT)
                ->setAmmoTypeId($dbLine->AMMO_ID);

            return $line;
        }

        /**
         * Saves this line.
         * @param int $fitId
         */
        public function persistToFit(int $fitId):void {
            DB::table("parsed_fit_items")->insert([
                'FIT_ID' => $fitId,
                'ITEM_ID' => $this->typeId,
                'COUNT' => $this->count,
                'AMMO_ID' => $this->ammoTypeId
            ]);
        }

	}
