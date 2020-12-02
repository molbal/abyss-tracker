<?php


	namespace App\Http\Controllers\Misc;


	use App\Http\Controllers\Controller;
    use App\Http\Controllers\Misc\DTO\PatreonDonor;
    use Illuminate\Contracts\Filesystem\FileNotFoundException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Storage;


    class DonorController extends Controller {

        /**
         * @return \Illuminate\Support\Collection
         */
        private function getPatreonList():\Illuminate\Support\Collection {
            return Cache::remember("aft.patreon.donors", now()->addMinute(), function () {

                try {
                    $file = Storage::disk('private')->get("Members.csv");
                } catch (FileNotFoundException $e) {
                    Log::warning('Could not find members.csv');
                    return collect([]);
                }

                $lines = collect(explode("\r\n", $file));
                $list = collect([]);

                foreach ($lines as $i => $line) {
                    if ($line == "") continue;
                    if ($i == 0) continue;

                    $raw = explode(",", $line);
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

        /**
         * Gets the donations
         * @param int $limit
         *
         * @return \Illuminate\Support\Collection
         */
        public function getDonations(int $limit, int $minimumAmount = 0, bool $opsecSkipped = false) {
            return Cache::remember(sprintf("aft.donations.ingame.%d.%d.%s",$limit,$minimumAmount, $opsecSkipped ? "t" : "f"), now()->addMinutes(5), function () use ($limit, $minimumAmount, $opsecSkipped) {
                $builder = DB::table("donors")
                                    ->where("AMOUNT", ">=", $minimumAmount);
                if ($opsecSkipped) {
                    $builder->whereRaw("UPPER(REASON)<>'PRIVATE'");
                }
                return $builder->orderBy("DATE", "DESC")->limit($limit)->get();
            });

        }

        public function index() {
            $donors  = $this->getPatreonList();
            $ingameDonors = $this->getDonations(100, 50000);
            return view("donors", [
                'patreon' => $donors,
                'ingameDonors' => $ingameDonors
            ]);
        }
	}
