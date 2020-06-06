<?php


    namespace App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\Impl;

    use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator\ISingleItemEstimator;
    use Illuminate\Support\Facades\Cache;

    class CacheSingleItemEstimator implements ISingleItemEstimator {

        private $typeId;

        /**
         * EveWorkbenchSingleItemEstimator constructor.
         *
         * @param $typeId
         */
        public function __construct($typeId) {
            $this->typeId = $typeId;
        }

        /**
         * @return ItemObject
         * @throws RemoteAppraisalToolException
         */
        public function getPrice() : ?ItemObject {
            try {

                if (Cache::has("aft.singleitemestimator." . $this->typeId)) {
                    $itemObj = new ItemObject();
                    $itemObj->unserialize(Cache::get("aft.singleitemestimator." . $this->typeId));
                    return $itemObj;
                } else {
                    return null;
                }

            } catch (\Exception $e) {
                return null;
            }
        }
    }
