<?php


	namespace App\Http\Controllers\ConduitImpl;


	use App\Http\Controllers\ConduitController;
    use App\Item;

    class ItemConduitControllers extends ConduitController {

        /**
         * List dropped items
         *
         * Lists all items dropped from Abyssal Deadspace
         *
         * @group Loot table
         *
         * @responseField success boolean true on normal operation, false on exception
         * @responseField error string|null null on normal operation, string containing error message on exception
         * @responseField char object contains the authenticated character's ID and name
         * @responseField char.id int|null authenticated character's ID  (might be null on error)
         * @responseField char.name string|null authenticated character's name (might be null on error)
         *
         *
         * @return \Illuminate\Support\Collection
         */
        public function getDroppedItems() {
            return Item::getAll();
        }
	}
