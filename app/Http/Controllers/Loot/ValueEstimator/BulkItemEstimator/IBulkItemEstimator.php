<?php


	namespace App\Http\Controllers\Loot\ValueEstimator\BulkItemEstimator;


	use App\Http\Controllers\EFT\DTO\ItemObject;
    use App\Http\Controllers\EFT\Exceptions\RemoteAppraisalToolException;
    use Illuminate\Support\Collection;

    interface IBulkItemEstimator {

        /**
         * IBulkItemEstimator constructor.
         *
         * @param Collection $listOfTypeIds
         */
        public function __construct(Collection $listOfTypeIds);

        /**
         * @return Collection
         * @throws RemoteAppraisalToolException
         */
        public function getPrices(): Collection;
	}
