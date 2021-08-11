<?php


    namespace App\Http\Controllers\Misc;


    use App\Http\Controllers\EFT\FitHelper;
    use Illuminate\Support\Collection;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class MassItemSlotClassifier {

        private Collection $itemClass;

        private FitHelper $helper;

        /**
         * MassItemSlotClassifier constructor.
         *
         * @param Collection $itemIds
         *
         * @throws \Exception
         */
        private function __construct(Collection $itemIds) {
            $this->helper = FitHelper::getInstance();

            clock()->event("Loading item classifier cached entries", "")->begin();
            $itemClasses = DB::table('item_slot')
                ->whereIn('ITEM_ID', $itemIds)
                ->get(['ITEM_ID as id', 'ITEM_SLOT as class']);

            clock()->event("Loading item classifier cached entries", "")->end();
            if ($itemIds->count() == $itemClasses->count()) {
                $this->itemClass = $itemClasses;
                return;
            }
            Log::warning(sprintf("Not all items were cached: %d / %d", $itemClasses->count(), $itemIds->count()));

            clock()->event("Building item classifier cache", "")->begin();
            foreach ($itemIds as $itemId) {
                if ($itemClasses->firstWhere('id', $itemIds)) continue;

                Log::warning('Not cached, preloading: '.$itemId);
                $itemClasses->add([
                    'id' => $itemId,
                    'class' => $this->helper->getItemSlot($itemId)
                ]);
            }
            clock()->event("Building item classifier cache", "")->end();
            $this->itemClass = $itemClasses;
        }

        /**
         * @param Collection|array $itemIds
         *
         * @return MassItemSlotClassifier
         */
        public static function preLookup(Collection|array $itemIds) : MassItemSlotClassifier {
            if (is_array($itemIds)) {
                return new self(collect(array_unique($itemIds)));
            }
            else {
                return new self($itemIds->unique());
            }

        }

        public function getItemSlot(int $itemId): string {
            $item = $this->itemClass->firstWhere('id','=',$itemId);
            if (isset($item->class) && !is_null($item->class)) {
                return $item->class;
            }

            try {
                return $this->helper->getItemSlot($itemId);
            }
            catch (\Exception $e) {
                Log::warning("Could not get item slot: ".get_class($e).": ".$e->getMessage());
                return 0;
            }
        }


    }
