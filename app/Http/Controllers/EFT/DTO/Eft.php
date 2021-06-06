<?php


	namespace App\Http\Controllers\EFT\DTO;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\Exceptions\FitNotFoundException;
    use App\Http\Controllers\EFT\FitHelper;
    use App\Http\Controllers\EFT\FitParser;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use App\Pvp\PvpShipStat;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

    class Eft {

        private bool $isPvpFit;

	    /** @var Collection */
	    private $lines;

	    /** @var int */
	    private $shipId;

	    /** @var string */
	    private $fitName;

	    /** @var FitHelper */
	    private $fitHelper;

	    /** @var ItemPriceCalculator */
	    private $priceEstimator;

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

        public function getShipName(): string {
            /** @var ResourceLookupService $resouceLookupService */
            $resouceLookupService = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');
            return $resouceLookupService->generalNameLookup($this->getShipId());
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

        public function canGoToAbyss() {
            return DB::table("ship_lookup")->where('ID', $this->shipId)->exists();
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
         * @return bool
         */
        public function isPvpFit() : bool {
            return $this->isPvpFit;
        }

        /**
         * @param bool $isPvpFit
         *
         * @return Eft
         */
        public function setIsPvpFit(bool $isPvpFit) : Eft {
            $this->isPvpFit = $isPvpFit;

            return $this;
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
            $eft->setIsPvpFit(false);
            return $eft;
        }

        public static function loadPvpFit(int $killmailId) {
            /** @var FitParser $parser */
            $parser = resolve('App\Http\Controllers\EFT\FitParser');

            $stats = PvpShipStat::whereKillmailId($killmailId)->firstOrFail();

            $eft = $parser->getFitTypes($stats->eft)->setIsPvpFit(true);
            return $eft;
        }

        /**
         * @return FitHelper
         */
        public function getFitHelper() : FitHelper {
            if ($this->fitHelper == null) {
                $this->fitHelper = resolve('App\Http\Controllers\EFT\FitHelper');
            }
            return $this->fitHelper;
        }



        public function getStructuredDisplay() {
            $struct = ['high' => [], 'mid' => [], 'low' => [], 'rig' => [], 'drone' => [], 'ammo' => [], 'cargo' => [], 'booster' => [], 'implant' => []];
            /** @var FitHelper $helper */
            foreach ($this->lines as $line) {
                /** @var EftLine $line */
                try {
                    $struct[$this->getFitHelper()->getItemSlot($line->getTypeId())][] = $line;
                } catch (\Exception $e) {
                    $struct['cargo'][] = $line;
                }
            }
            return $struct;
        }

        /**
         * @return ItemPriceCalculator
         */
        public function getPriceEstimator() : ItemPriceCalculator {
            if ($this->priceEstimator == null) {
                $this->priceEstimator = resolve('App\Http\Controllers\EFT\ItemPriceCalculator');
            }
            return $this->priceEstimator;
        }




        /**
         * Gets the value of the entire fit
         * @return int
         */
        public function getFitValue():int {
            $value = $this->getItemsValue();

            $itemObject = $this->getPriceEstimator()->getFromTypeId($this->getShipId());
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
            $itemsValue = 0;

            $typeIds = $this->lines->map(function( /** @var $item EftLine */ $item) {
                return $item->getTypeId();
            })->unique();

            $prices = $this->getPriceEstimator()->appraiseBulk($typeIds);
            $this->lines->transform(function ($line) use (&$itemsValue, $prices) {
                /** @var EftLine $line */
                $itemObject = $prices->filter(function ($item) use ($line) {
                    return $line->getTypeId() == $item->getTypeId();
                })->first();

                if ($itemObject) {
                    $itemsValue += $itemObject->getAveragePrice();
                    $line->setAveragePrice(intval($itemObject->getAveragePrice()));
                }
                return $line;

            });

            return $itemsValue;
        }

        public function isDefaultName() {
            $fitName = strval(Str::of($this->getFitName())->upper()->trim());
            $shipName = Str::upper($this->getShipName());

            return (
                   $fitName == "SIMULATED $shipName FITTING"
                || $fitName == "$shipName FIT")
                || $fitName == $shipName;
        }
    }
