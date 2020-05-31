<?php


	namespace App\Http\Controllers;


	use App\Http\Controllers\DS\FitBreakEvenCalculator;
    use App\Http\Controllers\DS\MedianController;
    use App\Http\Controllers\EFT\FitHelper;
    use App\Http\Controllers\EFT\Tags\TagsController;
    use App\Http\Controllers\Loot\EveItem;
    use App\Http\Controllers\Loot\LootValueEstimator;
    use App\Http\Controllers\Partners\EveWorkbench;
    use App\Http\Controllers\Youtube\YoutubeController;
    use ChrisKonnertz\OpenGraph\OpenGraph;
    use Cohensive\Embed\Embed;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;

    class FitsController extends Controller {

        /** @var FitHelper */
        protected $fitHelper;

        /**
         * FitsController constructor.
         *
         * @param FitHelper $fitHelper
         */
        public function __construct(FitHelper $fitHelper) {
            $this->fitHelper = $fitHelper;
        }


        /**
         * Renders the new fit screen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function new() {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please sign in first to add a new fit"]);
            }
            return view("new_fit");
	    }

        /**
         * Handles fit deletion
         * @param int $id
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function delete(int $id) {
            if (!session()->has("login_id")) {
                return view("403", ["error" => "Please sign in first"]);
            }
            $fit = DB::table("fits")->where("ID", $id)->get()->get(0);

            if ($fit->CHAR_ID != session()->get("login_id", -1)) {
                return view('403', ['error' => sprintf("You cannot delete someone else's fit.")]);
            }

            try {
                DB::beginTransaction();
                DB::table("fit_tags")->where("FIT_ID", $id)->delete();
                DB::table("fit_recommendations")->where("FIT_ID", $id)->delete();
                DB::table("fits")->where("ID", $id)->where("CHAR_ID", session()->get("login_id"))->delete();
                DB::commit();
                return view("sp_message", ['title' => "Fit deleted", 'message' =>"The fit and all its data was removed from the Abyss Tracker."]);
            }
            catch (\Exception $e) {
                DB::rollBack();
                Log::error("Transaction rolled back - Could not delete fit $id - ".$e->getMessage(). " ".$e->getFile()."@".$e->getLine());
                return view("error", ["error" => "Something went wrong and could not delete this fit. Modifications reverted."]);
            }
        }

        /**
         * Handles fit privacy change
         *
         * @param int    $id
         *
         * @param string $privacySetting
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         */
        public function changePrivacy(int $id, string $privacySetting) {
            if (!session()->has("login_id")) {
                return view("403", ["error" => "Please sign in first"]);
            }
            $fit = DB::table("fits")->where("ID", $id)->get()->get(0);

            if ($fit->CHAR_ID != session()->get("login_id", -1)) {
                return view('403', ['error' => sprintf("You cannot modify someone else's fit.")]);
            }

            try {
                DB::table("fits")->where("ID", $id)->where("CHAR_ID", session()->get("login_id"))->update([
                    'PRIVACY' => $privacySetting
                ]);
                return redirect(route("fit_single",['id' => $id]));
            }
            catch (\Exception $e) {
                Log::error("Transaction rolled back - Could not change fit privacy $id - ".$e->getMessage(). " ".$e->getFile()."@".$e->getLine());
                return view("error", ["error" => "Something went wrong and could not delete this fit. Modifications reverted."]);
            }
        }

        /**
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector|\Illuminate\View\View
         * @throws \Exception
         */
        public function new_store(Request $request) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please sign in first to add a new fit"]);
            }
            Validator::make($request->all(), [
                'ELECTRICAL'     => 'required|numeric|min:0|max:5',
                'DARK'     => 'required|numeric|min:0|max:5',
                'EXOTIC' => 'required|numeric|min:0|max:5',
                'FIRESTORM'   => 'required|numeric|min:0|max:5',
                'GAMMA' => 'required|numeric|min:0|max:5',
                'eft'  => 'required',
//                'description' => 'required',
                'privacy' => 'required'
            ], [
                'required' => "Please fill :attribute before saving your fit",
            ])->validate();


            $id = null;
            try {
                if (
                    $request->get("ELECTRICAL") == 0 &&
                    $request->get("DARK") == 0 &&
                    $request->get("EXOTIC") == 0 &&
                    $request->get("FIRESTORM") == 0 &&
                    $request->get("GAMMA") == 0
                )
                {
                    throw new \Exception("Please mark at least one type/tier possible in this fit.");
                }
                $eft = $request->get("eft");
                $shipId = $this->getShipIDFromEft($eft);
                if (!DB::table("ship_lookup")->where("ID", $shipId)->exists()) {
                    throw new \Exception("Please select a ship that is allowed to enter the Abyssal Deadspace");
                }

                $shipName = $this->getFitName($eft);

                // Get price
                $lootEstimator = new LootValueEstimator(preg_replace('/^\[Empty.+slot\]$/im', '', $eft) ?? "");

                // Update each price
                /** @var EveItem[] $items */
                $items = $lootEstimator->getItems();
                foreach ($items as $item) {
                    LootValueEstimator::setItemPrice($item);
                }
                $hash = $this->fitHelper->getFitFFH($eft);
                DB::beginTransaction();
                $id = DB::table("fits")->insertGetId([
                    'CHAR_ID' => session()->get("login_id"),
                    'SHIP_ID' => $shipId,
                    'NAME' => $shipName,
                    'DESCRIPTION' => $request->get("description"),
                    'STATS' => json_encode([]),
                    'STATUS' => 'queued',
                    'PRICE' => $lootEstimator->getTotalPrice(),
                    'RAW_EFT' => $eft,
                    'SUBMITTED' => now(),
                    'VIDEO_LINK' => $request->get("video_link") ?? '',
                    'PRIVACY' => $request->get('privacy'),
                    'FFH' => $hash
                ]);

                if (!$this->submitSvcFitService($this->fitHelper->pyfaBugWorkaround($eft, $shipId), $id)) {
                    throw new \RuntimeException("Unable to submit this fit to processing.");
                }

                DB::table("fit_recommendations")->insert([
                    'FIT_ID' => $id,
                    'ELECTRICAL' => $request->get("ELECTRICAL"),
                    'DARK' => $request->get("DARK"),
                    'EXOTIC' => $request->get("EXOTIC"),
                    'FIRESTORM' => $request->get("FIRESTORM"),
                    'GAMMA' => $request->get("GAMMA")
                ]);
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error while saving new fit: ".$e->getMessage()." ".$e->getFile()."@".$e->getLine());
                return view('error', ['error' => "Could not save fit: ".$e->getMessage()]);
            }

            return redirect(route('fit_single', ['id' => $id]));
	    }

        /**
         * @return FitHelper
         */
        public function getFitHelper() : FitHelper {
            return $this->fitHelper;
        }

        /**
         * Handles the display for a ship fit
         *
         * @param int $id
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         * @throws \Exception
         */
        public function get(int $id) {
            if (!DB::table("fits")
                   ->where("ID", $id)
                   ->exists()) {
                return view('error', ['error' => sprintf("Can not find a fit with ID %d", $id)]);
            }

            $fit = Cache::remember("aft.fit-full.".$id, now()->addMinutes(5), function () use ($id) {
                return DB::table("fits")
                         ->where("ID", $id)
                         ->first();
            });


            if ($fit->PRIVACY == 'private' && $fit->CHAR_ID != session()->get("login_id", -1)) {
                return view('403', ['error' => sprintf("<p class='mb-0'>This is a private fit. <br> <a class='btn btn-link mt-3' href='" . route('home_mine') . "'>View public fits</a></p>")]);
            }
            $ship_name = DB::table('ship_lookup')
                           ->where('ID', $fit->SHIP_ID)
                           ->value('NAME');
            $char_name = DB::table('chars')
                           ->where('CHAR_ID', $fit->CHAR_ID)
                           ->value('NAME');


            $description = (new \Parsedown())->setSafeMode(true)
                                             ->parse($fit->DESCRIPTION);
            $ship_type = DB::table("ship_lookup")
                           ->where("ID", $fit->SHIP_ID)
                           ->value("GROUP") ?? "Unknown type";
            $ship_price = (DB::table("item_prices")
                             ->where("ITEM_ID", $fit->SHIP_ID)
                             ->value("PRICE_BUY") + DB::table("item_prices")
                                                      ->where("ITEM_ID", $fit->SHIP_ID)
                                                      ->value("PRICE_SELL") / 2) ?? 0;

            if (trim($fit->VIDEO_LINK)) {
                try {
                    $embed = YoutubeController::getEmbed($fit->VIDEO_LINK);
                } catch (\Exception $exception) {
                    Log::warning(sprintf("Could not generate embed for %s", $fit->VIDEO_LINK));
                    $embed = "<div class='alert alert-warning'>Could not generate embed for link: " . htmlentities($fit->VIDEO_LINK) . '</div>';
                }
            } else {
                $embed = "";
            }

            $recommendations = DB::table("fit_recommendations")
                                 ->where("FIT_ID", $id)
                                 ->first();

            $og = new OpenGraph();
            $og->title(sprintf("%s fit - %s", $ship_name, env("APP_NAME")))
               ->type('profile')
               ->description(sprintf("%s fit - %s", $ship_name, env("APP_NAME")))
               ->url()
               ->locale('en_US')
               ->localeAlternate(['en_UK'])
               ->siteName(env('APP_NAME'))
               ->determiner('an')
               ->image("https://images.evetech.net/types/$fit->SHIP_ID/render?size=256", ['width' => 256, 'height' => 256]);
            $og->profile(["first_name" => trim($fit->NAME)]);

            if (session()->has("login_id")) {
                if (Cache::has("aft.fit.last-seen-".session()->get("login_id"))) {
                    Cache::forget("aft.fit.last-seen-".session()->get("login_id"));
                }
                Cache::put("aft.fit.last-seen-".session()->get("login_id"),  $id,now()->addHour());
            }

            $runs = DB::table("runs")
              ->where("FIT_ID", $id)
              ->orderBy("CREATED_AT", 'DESC')
              ->paginate(25);

            $maxTiers = FitBreakEvenCalculator::getMaxTiers($id);
            $breaksEven = FitBreakEvenCalculator::breaksEvenCalculation($id, $maxTiers, $fit);

            $eftParsed = $this->fitHelper->quickParseEft($fit->RAW_EFT);
            $price = $ship_price;
            foreach ($eftParsed as $slot) {
                foreach ($slot as $item) {
                    $price += $item['price']->getAveragePrice();
                }
            }
            $fit->PRICE = $price;
            DB::table("fits")->where("ID", $id)->update(['PRICE' => $price]);
            return view('fit', [
                'fit' => $fit,
                'ship_name' => $ship_name,
                'char_name' => $char_name,
                'ship_type' => $ship_type,
                'ship_price' => $ship_price,
                'fit_quicklook' => $eftParsed,
                'description' => $description,
                'eve_workbench_url' => EveWorkbench::getProfileUrl($char_name),
                'embed' => $embed,
                'recommendations' => $recommendations,
                'og' => $og,
                'id' => $id,
                'runs' => $runs,
                "breaksEven" => $breaksEven
            ]);
	    }

        /**
         * @param string $eft
         * @param int    $fitId
         *
         * @return bool
         * @throws \Exception
         */
        public function submitSvcFitService(string $eft, int $fitId) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,env("FIT_SERVICE_URL"));
            curl_setopt($ch, CURLOPT_POST, true);
            $query = http_build_query(['fit' => $eft, 'appId' => env("FIT_SERVICE_APP_ID"), 'appSecret' => env('FIT_SERVICE_APP_SECRET'), 'fitId' => $fitId]);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            curl_setopt($ch, CURLOPT_VERBOSE, true);
            curl_setopt($ch,CURLOPT_STDERR ,fopen('./svcfitstat.log', 'w+'));
            // Receive server response ...
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            if (!$response) {
                throw new \Exception("The fit stat service did not respond");
            }

            $responseData = json_decode($response, true);
            if (!$responseData) {
                Log::error("Invalid response from fit stat service: ".$responseData." for input ".$query);
                throw new \Exception("The fit stat service returned malformed response");
            }

            if(!isset($responseData["success"])) {
                throw new \RuntimeException("No 'status' key in SVCFITSTAT response: ".print_r($responseData, 1));
            }

            if ($responseData["success"]) {
                Log::info("Submitted fit to svcfitstat. ".print_r($responseData, 1));
                return true;
            }
            else {
                Log::error("Negative response input ".$query.": ".print_r($responseData, true));
                return false;
            }
	    }

        /**
         * @param string $fit
         *
         * @return mixed
         * @throws \Exception
         */
        private function getFitName(string $fit): string {

            // Get lines
            $lines = explode("\n", trim($fit));

            // Get and strip the first line
            try {
                $shipName = explode(",", explode("[", $lines[0],2)[1], 2)[1];
                $shipName = str_replace("]", "", $shipName);
            }
            catch (\Exception $e) {
                Log::warning("Could not extract the ship name from the EFT fit. ".$e->getMessage()." ".$e->getFile()." ".$e->getLine());
                throw new \Exception("Could not extract the ship name from the EFT fit. ", 0, $e);
            }

            return $shipName;
	    }

        /**
         * @param string $fit
         *
         * @return mixed
         * @throws \Exception
         */
        private function getShipIDFromEft(string $fit) {

            // Get lines
            $lines = explode("\n", trim($fit));

            // Get and strip the first line
            try {
                $shipName = explode(",", explode("[", $lines[0],2)[1], 2)[0];
            }
            catch (\Exception $e) {
                Log::warning("Could not extract the ship name from the EFT fit. ".$e->getMessage()." ".$e->getFile()." ".$e->getLine());
                throw new \Exception("Could not extract the ship name from the EFT fit. ", 0, $e);
            }

            Log::debug("Found ship: ".$shipName);

            $shipId = DB::table("ship_lookup")->where('NAME', ucfirst(strtolower($shipName)))->value('ID');

            if (!$shipId) {
                throw new \Exception("Broken ship fit, unsupported fit, or the selected ship cannot go into the Abyss.");
            }

            return $shipId;
	    }



    }
