<?php


	namespace App\Http\Controllers\EFT\DTO;


	use App\Http\Controllers\EFT\Exceptions\FitNotFoundException;
    use App\Http\Controllers\EFT\FitHelper;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

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

        /**
         * Persists all lines
         * @param int $fitId
         */
        public function persistLines(int $fitId):void {
            $this->lines->map(function ($item, $key) use ($fitId) {
                /** @var EftLine $item */
                $item->persistToFit($fitId);
            });
        }

        /**
         * @param int $fitId
         *
         * @throws FitNotFoundException Fit not found
         */
        public function load(int $fitId):void {

            if (!DB::table("fits")->where("ID", $fitId)->exists()) {
                throw new FitNotFoundException("No fit found with ID $fitId");
            }

            $tmp = DB::table("fits")->where("ID", $fitId)->first();
            $this->shipId = $tmp->SHIP_ID;
            $this->fitName = $tmp->NAME;

            $dbLines = DB::table("parsed_fit_items")
                            ->where("FIT_ID", $fitId)
                            ->get();

            $this->lines = collect([]);
            $dbLines->each(function ($item, $key) {
               $this->lines->add(EftLine::fromDb($item));
            });
        }

        /**
         * @param int $fitId
         *
         * @return Eft
         * @throws FitNotFoundException Fit not found
         */
        public static function loadFromId(int $fitId):Eft {
            $eft = new Eft();
            $eft->load($fitId);
            return $eft;
        }

        public function getStructuredDisplay() {
            $struct = ['high' => [], 'mid' => [], 'low' => [], 'rig' => [], 'drone' => [], 'ammo' => [], 'cargo' => [], 'booster' => [], 'implant' => []];
            /** @var FitHelper $helper */
            $helper = resolve('App\Http\Controllers\EFT\FitHelper');
            foreach ($this->lines as $line) {
                /** @var EftLine $line */
                try {
                    $struct[$helper->getItemSlot($line->getTypeId())][] = $line;
                } catch (\Exception $e) {
                    $struct['cargo'][] = $line;
                }
            }
            return $struct;
        }


        /**
         * Gets the value of the entire fit
         * @return int
         */
        public function getFitValue():int {
            $value = $this->getItemsValue();

            /** @var ItemPriceCalculator $priceEstimator */
            $priceEstimator = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');
            $itemObject = $priceEstimator->getFromTypeId($this->getShipId());
            if ($itemObject) {
                $value += $itemObject->getAveragePrice();
            }

            return $value;
        }

        /**
         * Gets the value of all items
         * @return float|int
         */
        public function getItemsValue() {
            $value =  0;

            /** @var ItemPriceCalculator $priceEstimator */
            $priceEstimator = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');
            /** @var EftLine $line */
            foreach ($this->lines as $line) {
                $itemObject = $priceEstimator->getFromTypeId($line->getTypeId());
                if ($itemObject) {
                    $value += $itemObject->getAveragePrice();
                }
            }

            return $value;
        }
    }
