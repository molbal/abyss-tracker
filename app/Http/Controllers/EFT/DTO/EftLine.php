<?php


    namespace App\Http\Controllers\EFT\DTO;


    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use Illuminate\Support\Facades\DB;

    class EftLine {

        /** @var int */
        private $typeId;

        /** @var int */
        private $count;

        /** @var int */
        private $ammoTypeId;

        /** @var ResourceLookupService */
        private $resolver;

        /** @var ItemPriceCalculator */
        private $ipc;

        /**
         * EftLine constructor.
         */
        public function __construct() {
            $this->itemName = null;
            $this->ammoName = null;
            $this->resolver = null;
            $this->ipc = null;
        }


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
         * @return int
         */
        public function getAveragePrice():int {
            if (!$this->typeId) return 0;
            $o = $this->getItemPriceCalculator()->getFromTypeId($this->typeId);
            if ($o) {
                return intval($o->getAveragePrice());
            }
            return 0;
        }

        /**
         * @return ItemPriceCalculator
         */
        protected function getItemPriceCalculator(): ItemPriceCalculator {
            if ($this->ipc == null) $this->ipc = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');

            return $this->ipc;

        }

        /**
         * @return bool
         */
        public function hasAmmo():bool {
            return $this->ammoTypeId == null ? false : true;
        }

        /**
         * @return ResourceLookupService
         */
        protected function getResolver() : ResourceLookupService {
            if ($this->resolver == null) $this->resolver = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');

            return $this->resolver;
        }


        /** @var string */
        private $itemName;

        /**
         * Gets the item name
         * @return string|null
         */
        public function getItemName() {
            if ($this->itemName) return $this->itemName;
            if ($this->typeId) {
                try {
                    $this->itemName = $this->getResolver()
                                           ->generalNameLookup($this->typeId);
                } catch (\Exception $e) {
                    $this->itemName = null;
                }
            }

            return $this->itemName;
        }

        /** @var string */
        private $ammoName;

        /**
         * Gets the ammo name
         * @return string|null
         */
        public function getAmmoName() {
            if ($this->ammoTypeId == null) return "";
            if ($this->ammoName) return $this->ammoName;
            if ($this->typeId) {
                /** @var ResourceLookupService $res */
                $res = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');
                try {
                    $this->ammoName = $this->getResolver()
                                           ->generalNameLookup($this->ammoTypeId);
                } catch (\Exception $e) {
                    $this->ammoName = null;
                }
            }

            return $this->ammoName;
        }


        /**
         * @return int|null
         */
        public function getAmmoTypeId(): ?int {
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
        public static function fromDb($dbLine) : EftLine {
            $line = new EftLine();
            $line->setTypeId($dbLine->ITEM_ID)
                 ->setCount($dbLine->COUNT)
                 ->setAmmoTypeId($dbLine->AMMO_ID);

            return $line;
        }

        /**
         * Saves this line.
         *
         * @param int $fitId
         */
        public function persistToFit(int $fitId) : void {
            DB::table("parsed_fit_items")
              ->insert(['FIT_ID' => $fitId, 'ITEM_ID' => $this->typeId, 'COUNT' => $this->count, 'AMMO_ID' => $this->ammoTypeId]);
        }

        /**
         * Gets this entity as legit formatted EFT line
         * @return string|null
         */
        public function toEftLine() {
            if ($this->hasAmmo()) {
                return sprintf("%s, %s", $this->getItemName(), $this->getAmmoName());
            }
            else if ($this->count>1) {
                return sprintf("%s x%d", $this->getItemName(), $this->getCount());
            }
            else {
                return $this->getItemName();
            }
        }

    }
