<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\SingleItemEstimator;


	use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;

    interface ISingleItemEstimator {

        /**
         * ISingleItemEstimator constructor.
         *
         * @param int $typeId
         */
	    public function __construct(int $typeId);

        /**
         * @return ItemObject
         * @throws RemoteAppraisalToolException
         */
        public function getPrice(): ?ItemObject;

	}
