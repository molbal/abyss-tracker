<?php


	namespace App\Http\Controllers\Misc;


	use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\EFT\FitHelper;
    use Illuminate\Contracts\Container\BindingResolutionException;
    use Illuminate\Log\Logger;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\Log;

    class MassConvertedItemIds {

        private Collection $itemIds;

        private ResourceLookupService $resourceLookupService;

        /**
         * @param Collection|array $itemNames
         *
         * @return MassConvertedItemIds
         */
        public static function preLookup(Collection|array $itemNames) : MassConvertedItemIds {
            if (is_array($itemNames)) {
                return new self(collect($itemNames));
            }
            else {
                return new self($itemNames);
            }
        }

        /**
         * MassConvertedItemIds constructor.
         *
         * @param Collection $itemNames
         */
        public function __construct(Collection $itemNames) {
            $this->resourceLookupService = app()->make(ResourceLookupService::class);
            try {
                $this->itemIds = $this->resourceLookupService->massItemNamesToId($itemNames);
            }
            catch (\Exception $e) {
                Log::warning(sprintf("Could not mass convert item names to IDs: %s: %s", get_class($e), $e->getMessage()));
                $this->itemIds = collect([]);
            }
        }

        /**
         * @return ResourceLookupService
         */
        public function getResourceLookupService() : ResourceLookupService {
            return $this->resourceLookupService;
        }


        /**
         * @param string $itemName
         *
         * @return int
         */
        public function getId(string $itemName) : int {
            $item = $this->itemIds->firstWhere('name','=',$itemName);
            if (isset($item->id) && !is_null($item->id)) {
                return $item->id;
            }
            else {
                try {
                    return $this->resourceLookupService->itemNameToId($itemName);
                }
                catch (\Exception $e) {
                    Log::warning("Could not convert item to ID: ".get_class($e).": ".$e->getMessage());
                    return 0;
                }
            }
        }

    }
