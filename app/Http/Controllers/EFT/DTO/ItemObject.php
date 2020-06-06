<?php


	namespace App\Http\Controllers\EFT\DTO;


	class ItemObject implements \Serializable{

	    /** @var string */
	    protected $name;

	    /** @var int */
	    protected $typeId;

	    /** @var float */
	    protected $buyPrice;

	    /** @var float */
	    protected $sellPrice;

        /**
         * @return string
         */
        public function getName() : string {
            return $this->name;
        }

        /**
         * @param string $name
         *
         * @return ItemObject
         */
        public function setName(string $name) : ItemObject {
            $this->name = $name;

            return $this;
        }

        /**
         * @return int
         */
        public function getTypeId() : int {
            return $this->typeId;
        }

        /**
         * @param int $typeId
         *
         * @return ItemObject
         */
        public function setTypeId(int $typeId) : ItemObject {
            $this->typeId = $typeId;

            return $this;
        }

        /**
         * @return float
         */
        public function getBuyPrice() : float {
            return $this->buyPrice;
        }

        /**
         * @param float $buyPrice
         *
         * @return ItemObject
         */
        public function setBuyPrice(float $buyPrice) : ItemObject {
            $this->buyPrice = $buyPrice;

            return $this;
        }

        /**
         * @return float
         */
        public function getAveragePrice():float {
            return ($this->sellPrice+$this->buyPrice)/2;
        }

        /**
         * @return float
         */
        public function getSellPrice() : float {
            return $this->sellPrice;
        }

        /**
         * @param float $sellPrice
         *
         * @return ItemObject
         */
        public function setSellPrice(float $sellPrice) : ItemObject {
            $this->sellPrice = $sellPrice;

            return $this;
        }

        /**
         * @inheritDoc
         */
        public function serialize():string {
            return serialize([
                $this->name, $this->typeId, $this->buyPrice, $this->sellPrice
            ]);
        }

        /**
         * @inheritDoc
         */
        public function unserialize($serialized) {
            [$this->name, $this->typeId, $this->buyPrice, $this->sellPrice] = unserialize($serialized);
        }
    }
