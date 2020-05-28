<?php


	namespace App\Http\Controllers\EFT\Tags;


	use App\Http\Controllers\EFT\DTO\ItemObject;

    interface ISingleItemEstimator {

        /**
         * ISingleItemEstimator constructor.
         *
         * @param int $typeId
         */
	    public function __construct(int $typeId);
        public function getPrice(): ItemObject;

	}
