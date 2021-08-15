<?php


	namespace App\Http\Controllers\ConduitImpl;


	use App\Http\Controllers\ConduitController;
    use App\Item;
    use Cache;
    use Exception;

    class ItemConduitControllers extends ConduitController {

        /**
         * List dropped items
         *
         * Lists all items dropped from Abyssal Deadspace. Cached for up to 15 minutes.
         *
         * @group Loot table
         *
         * @responseField success boolean true on normal operation, false on exception
         * @responseField error string|null null on normal operation, string containing error message on exception
         * @responseField char object contains the authenticated character's ID and name
         * @responseField char.id int|null authenticated character's ID  (might be null on error)
         * @responseField char.name string|null authenticated character's name (might be null on error)
         * @responseField items.*.id int EVE Type ID
         * @responseField items.*.name string EVE type name
         * @responseField items.*.group.id int EVE group ID
         * @responseField items.*.group.name string EVE group name
         * @responseField count int contains how many records were returned
         *
         *
         * @return array
         */
        public function getDroppedItems() {
            try {
                $items = Cache::remember('api.items.list', now()->addMinutes(15), fn () => Item::getAll());
                return $this->wrapListResponse($items);
            }
            catch (Exception $e) {
                return  $this->getErrorResponse($e);
            }
        }




        /**
         * Get a dropped item
         *
         * Gets a dropped item, including drop rates and limited market data. Cached for up to 1 minute.
         *
         * @group Loot table
         *
         * @urlParam id int EVE Type ID
         * @responseField success boolean true on normal operation, false on exception
         * @responseField error string|null null on normal operation, string containing error message on exception
         * @responseField char object contains the authenticated character's ID and name
         * @responseField char.id int|null authenticated character's ID  (might be null on error)
         * @responseField char.name string|null authenticated character's name (might be null on error)
         * @responseField items.*.id int EVE Type ID
         * @responseField items.*.name string EVE type name
         * @responseField items.*.group.id int EVE group ID
         * @responseField items.*.group.name string EVE group name
         * @responseField count int contains how many records were returned
         *
         *
         * @return array
         */
        public function getItem(int $id) {
            $item = Cache::remember('api.item.'.$id, now()->addMinute(), fn () => Item::where('ITEM_ID', $id)->firstOrFail()->mapToDetailed());
            return $this->wrapSingleResponse($item);
        }
	}
