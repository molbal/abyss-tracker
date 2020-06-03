<?php


	namespace App\Http\Controllers\Misc;


	use App\Http\Controllers\Controller;
    use App\Http\Controllers\Misc\DTO\PatreonDonor;
    use Illuminate\Contracts\Filesystem\FileNotFoundException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\Storage;


    class DonorController extends Controller {

        /**
         * @return \Illuminate\Support\Collection
         */
        private function getPatreonList():\Illuminate\Support\Collection {
            return Cache::remember("aft.patreon.donors", now()->addMinute(), function () {

            try {
                $file = Storage::disk('private')
                               ->get("Members.csv");
            } catch (FileNotFoundException $e) {
                return collect([]);
            }
            $lines = collect(explode("\r\n", $file));
            $list = collect([]);
            foreach ($lines as $i => $line) {
                if ($line == "") continue;
                if ($i == 0) continue;

                $raw = explode(",",$line);
                if (floatval($raw[5]) == 0.00) continue;
                $donor = new PatreonDonor();

                $donor->setName($raw[0])
                    ->setPatreonId($raw[21])
                    ->setTotalAmount($raw[5])
                    ->setActivePatron($raw[3] == 'Active patron');

                $list->add($donor);
            }
            $list = $list->sortByDesc(function (PatreonDonor $item, $key) {
                return $item->getTotalAmount();
            });

            return $list;
            });
        }

        public function index() {
            $donors  = $this->getPatreonList();
            dd($donors);
        }
	}
