<?php


	namespace App\Http\Controllers;


	use App\Charts\LootAveragesChart;
    use App\Charts\PersonalDaily;
    use App\Http\Controllers\DS\FitBreakEvenCalculator;
    use App\Http\Controllers\EFT\DTO\Eft;
    use App\Http\Controllers\EFT\FitHelper;
    use App\Http\Controllers\EFT\FitHistoryController;
    use App\Http\Controllers\EFT\FitParser;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use App\Http\Controllers\EFT\Tags\TagsController;
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

        /** @var FitSearchController */
        private $fitSearchController;

        /** @var FitHelper */
        protected $fitHelper;


        /** @var FitParser */
        protected $fitParser;

        /** @var ItemPriceCalculator */
        protected $sipc;

        /**
         * FitsController constructor.
         *
         * @param FitSearchController $fitSearchController
         * @param FitHelper           $fitHelper
         * @param BarkController      $barkController
         * @param FitParser           $fitParser
         * @param ItemPriceCalculator $sipc
         */
        public function __construct(FitSearchController $fitSearchController, FitHelper $fitHelper, BarkController $barkController, FitParser $fitParser, ItemPriceCalculator $sipc) {
            $this->fitSearchController = $fitSearchController;
            $this->fitHelper = $fitHelper;
            $this->barkController = $barkController;
            $this->fitParser = $fitParser;
            $this->sipc = $sipc;
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
                return view("autoredirect", ['title' => "Fit deleted", 'message' =>"The fit and all its data was removed from the Abyss Tracker.", "redirect" => route("fit.mine")]);
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
            $fit = DB::table("fits")->where("ID", $id)->first();

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

            Validator::make($request->all(), [
                'ELECTRICAL'     => 'required|numeric|min:0|max:6',
                'DARK'     => 'required|numeric|min:0|max:6',
                'EXOTIC' => 'required|numeric|min:0|max:6',
                'FIRESTORM'   => 'required|numeric|min:0|max:6',
                'GAMMA' => 'required|numeric|min:0|max:6',
                'eft'  => 'required',
//                'description' => 'required',
                'privacy' => 'required'
            ], [
                'required' => "Please fill :attribute before saving your fit",
            ])->validate();


            $id = null;
            try {
                if ($request->get("ELECTRICAL") == 0 &&
                    $request->get("DARK") == 0 &&
                    $request->get("EXOTIC") == 0 &&
                    $request->get("FIRESTORM") == 0 &&
                    $request->get("GAMMA") == 0) {
                    throw\Illuminate\Validation\ValidationException::withMessages([
                        'ELECTRICAL' => ['Please mark at least one type/tier possible in this fit.']
                    ]);
                }

                $eft = $request->get("eft");
                $shipId = self::getShipIDFromEft($eft);

                if (!DB::table("ship_lookup")->where("ID", $shipId)->exists()) {
                    throw new \Exception("Please select a ship that is allowed to enter the Abyssal Deadspace");
                }

                $fitObj = $this->fitParser->getFitTypes($eft);
                $totalPrice = $fitObj->getFitValue(); // Let's get this before the DB transaction starts

                $hash = $this->fitHelper->getFitFFH($eft);

                if ($request->filled("fitName")) {
                    $fitObj->setFitName($request->get("fitName"));
                }

                DB::beginTransaction();
                $id = DB::table("fits")->insertGetId([
                    'CHAR_ID' => session()->get("login_id", 0),
                    'SHIP_ID' => $shipId,
                    'NAME' => $fitObj->getFitName(),
                    'DESCRIPTION' => $request->get("description") ?? "",
                    'STATS' => json_encode([]),
                    'STATUS' => 'queued',
                    'PRICE' => $totalPrice,
                    'RAW_EFT' => $eft,
                    'SUBMITTED' => now(),
                    'VIDEO_LINK' => $request->get("video_link") ?? '',
                    'PRIVACY' => $request->get('privacy'),
                    'FFH' => $hash,
                    'ROOT_ID' => $id,
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

                $fitObj->persistLines($id);
                FitHistoryController::addEntry($id, "Fit submitted to the Abyss Tracker");
                DB::commit();
            }
            catch (\Exception $e) {
                DB::rollBack();
                Log::error("Error while saving new fit: ".$e->getMessage()." ".$e->getFile()."@".$e->getLine());
                return view('error', ['error' => "Could not save fit: ".$e->getMessage()]);
            }

            return redirect(route('fit_single', ['id' => $id]));
	    }


        public function updateDescription(Request $request) {

            Validator::make($request->all(), [
                'id'  => 'required|numeric',
                'description' => 'required'
            ], [
                'required' => "Please fill :attribute",
            ])->validate();


            $id = $request->get('id');
            $fit = DB::table("fits")->where("ID", $id)->select(['CHAR_ID'])->first();

            if ($fit->CHAR_ID != session()->get("login_id", -1)) {
                return view('403', ['error' => sprintf("You cannot modify someone else's fit.")]);
            }

            // Actually edit
            DB::beginTransaction();
            try {
                DB::table('fits')
                    ->where('id', $id)
                    ->update(['DESCRIPTION' => $request->get('description')]);

                // Write history
                FitHistoryController::addEntry($id, "Updated description");
                DB::commit();
            }
            catch (\Exception $e) {
                Log::error("Could not update description for $id ". $e->getMessage()." ".$e->getTraceAsString());
                return view("error", ["error" => "Something went wrong while updating description, sorry. ".$e->getMessage()]);
            }


            // Redirect with message
            return view('autoredirect', [
                'title' => "Success",
                'message' => "The description of this fit was updated",
                'redirect' => route('fit_single', ['id' => $id])
            ]);
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
            clock()->startEvent("Checking if exists", "");
                if (!$this->getFitsQB($id)
                          ->exists()) {
                    clock()->endEvent("Checking if exists");
                    return view('error', ['error' => sprintf("Can not find a fit with ID %d", $id)]);
                }
            clock()->endEvent("Checking if exists");

            try {

                // Get the fit - with some caching
                clock()->startEvent("Getting the fit from DB", "");
                $fit = Cache::remember("aft.fit-record-full.".$id, now()->addSeconds(15), function () use ($id) {
                    return $this->getFitsQB($id)->first();
                });
                clock()->endEvent("Getting the fit from DB");


                // Check credentials

                clock()->startEvent("Checking privacy", "");
                if ($fit->PRIVACY == 'private' && $fit->CHAR_ID != session()->get("login_id", -1)) {
                    return view('403', ['error' => sprintf("<p class='mb-0'>This is a private fit. <br> <a class='btn btn-link mt-3' href='" . route('fit.search') . "'>View public fits</a></p>")]);
                }
                clock()->endEvent("Checking privacy");

                // Get ship name and character name
                clock()->startEvent("Lookup ship name and character name", "");
                $ship_name = DB::table('ship_lookup')
                               ->where('ID', $fit->SHIP_ID)
                               ->value('NAME');
                $char_name = DB::table('chars')
                               ->where('CHAR_ID', $fit->CHAR_ID)
                               ->value('NAME');
                clock()->endEvent("Lookup ship name and character name");

                // Parse description, get ship type ID and ship name
                clock()->startEvent("Parse description, get ship type ID and ship name", "");
                $description = (new \Parsedown())->setSafeMode(true)->parse($fit->DESCRIPTION);
                $shipType = DB::table("ship_lookup")->where("ID", $fit->SHIP_ID)->value("GROUP") ?? "Unknown type";
                $shipitemObject = $this->sipc->getFromTypeId($fit->SHIP_ID);
                if (!$shipitemObject) {
                    throw new \Exception("Could not find the ship name from the ship ID (".$fit->SHIP_ID.") - This happens frequently during EVE downtime and will solve itself when EVE comes back online");
                }
                clock()->endEvent("Parse description, get ship type ID and ship name");

                // Get ship price
                clock()->startEvent("Get ship price", "");
                $shipPrice = $shipitemObject->getAveragePrice() ?? 0.0;
                clock()->endEvent("Get ship price");

                // Get video link
                clock()->startEvent("Parse fit video link", "");
                if (trim($fit->VIDEO_LINK)) {
                    try {
                        $embed = YoutubeController::getEmbed($fit->VIDEO_LINK);
                    } catch (\Exception $exception) {
                        Log::warning(sprintf("Could not generate embed for %s", $fit->VIDEO_LINK));
                        $embed = "<div class='alert alert-warning'>Could not generate embed for link: " . htmlentities($fit->VIDEO_LINK) . '</div>';
                    }
                } else { $embed = "";}
                clock()->endEvent("Parse fit video link");

                // Get recommendations
                clock()->startEvent("Load fit recommendations", "");
                $recommendations = DB::table("fit_recommendations")->where("FIT_ID", $id)->first();
                clock()->endEvent("Load fit recommendations");

                // Make open graph tags
                clock()->startEvent("Generate Open Graph tags", "");
                $og = new OpenGraph();
                $og->title(sprintf("%s fit - %s", $ship_name, config('app.name')))
                   ->type('profile')
                   ->description(sprintf("%s fit with %s on %s", $ship_name,TagsController::getFitTags($id)->join(", ", ", and "), config('app.name')))
                   ->url()
                   ->locale('en_US')
                   ->localeAlternate(['en_UK'])
                   ->siteName(config('app.name'))
                   ->determiner('an')
                   ->image("https://images.evetech.net/types/$fit->SHIP_ID/render?size=256", ['width' => 256, 'height' => 256]);
                $og->profile(["first_name" => trim($fit->NAME)]);
                clock()->endEvent("Generate Open Graph tags");

                // Get last runs with this fit
                clock()->startEvent("Load fit's saved runs", "");
                $runs = DB::table("runs")
                  ->where("FIT_ID", $id)
                  ->orderBy("CREATED_AT", 'DESC')
                  ->paginate(25);
                clock()->endEvent("Load fit's saved runs");

                // Get max tiers and "break even" stats
                clock()->startEvent("'Break even calculation' - determine max tiers", "");
                $maxTiers = FitBreakEvenCalculator::getMaxTiers($id);
                clock()->endEvent("'Break even calculation' - determine max tiers");
                clock()->startEvent("'Break even calculation' - calculate break even time", "");
                $breaksEven = FitBreakEvenCalculator::breaksEvenCalculation($id, $maxTiers, $fit);
                clock()->endEvent("'Break even calculation' - calculate break even time");


                // Get parsed items and price
                clock()->startEvent("Load EFT from ID", "");
                $eftObj = Eft::loadFromId($id);
                clock()->endEvent("Load EFT from ID");
                clock()->startEvent("Load structured, pre-parsed display", "");
                $eftParsed = $eftObj->getStructuredDisplay();
                clock()->endEvent("Load structured, pre-parsed display");
                clock()->startEvent("Calculate fit value", "");
                $fit->PRICE = $eftObj->getFitValue();
                $this->getFitsQB($id)->update(["PRICE" => $fit->PRICE]);
                clock()->endEvent("Calculate fit value");

                // Get similar fits
                clock()->startEvent("Get similar fits", "");
                $fitIdsAll = $this->getSimilarFitsAsIdList($fit->FFH, true);
                $fitIdsNonPrivate = $this->getSimilarFitsAsIdList($fit->FFH, false);
                $similars = $this->getFitsFromIds($fitIdsNonPrivate);
                clock()->endEvent("Get similar fits");

                clock()->startEvent("Make charts", "");
                $popularity = $this->getFitPopularityChart($fitIdsAll, "Fit");
                $loots = $this->getFitLootStrategyChart($fitIdsAll);
                clock()->endEvent("Make charts");

                // Get all runs count with this fit
                clock()->startEvent("Count all runs", "");
                $runsCountAll = DB::table("runs")
                      ->where("FIT_ID", $id)
                      ->orderBy("CREATED_AT", 'DESC')->count();
                clock()->endEvent("Count all runs");

                // Get history
                clock()->startEvent("Load history", "");
                $history = FitHistoryController::getFitHistory($id)->reverse();
                clock()->endEvent("Load history");

                return view('fit', [
                    'fit' => $fit,
                    'ship_name' => $ship_name,
                    'char_name' => $char_name,
                    'ship_type' => $shipType,
                    'ship_price' => $shipPrice,
                    'items_price' => $eftObj->getItemsValue(),
                    'fit_quicklook' => $eftParsed,
                    'description' => $description,
                    'eve_workbench_url' => EveWorkbench::getProfileUrl($char_name),
                    'embed' => $embed,
                    'recommendations' => $recommendations,
                    'og' => $og,
                    'id' => $id,
                    'runs' => $runs,
                    "breaksEven" => $breaksEven,
                    'popularity' => $popularity,
                    'loots' => $loots,
                    'fitIdsAll' => $fitIdsAll,
                    'fitIdsNonPrivate' => $fitIdsNonPrivate,
                    'similars' => $similars,
                    'runsCountAll' => $runsCountAll,
                    'history' => $history
                ]);

            }
            catch (\Exception $e)  {
                if (config("app.debug")) {
                    throw $e;
                }
                Log::error("Error viewing fit: ".$e." - ".$e->getMessage()." ".$e->getFile()." ".$e->getTraceAsString());
                return view("error", ["message" => "Sorry, we ran into trouble viewing this fit. Reason: ".$e->getMessage()]);
            }
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

            curl_setopt($ch, CURLOPT_URL,config('fits.service-url'));
            curl_setopt($ch, CURLOPT_POST, true);
            $query = http_build_query(['fit' => $eft, 'appId' =>config('fits.auth.id'), 'appSecret' => config('fits.auth.secret'), 'fitId' => $fitId]);
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

                FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
                throw new \Exception("The fit stat service returned malformed response");
            }

            if(!isset($responseData["success"])) {
                FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
                throw new \RuntimeException("No 'status' key in SVCFITSTAT response: ".print_r($responseData, 1));
            }

            if ($responseData["success"]) {
                FitHistoryController::addEntry($fitId, "Submitted fit for stats calculation");
                Log::info("Submitted fit to svcfitstat.");
                return true;
            }
            else {
                FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
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
        public static function getShipIDFromEft(string $fit) {

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



        /**
         * @param int $id
         *
         * @return \Illuminate\Database\Query\Builder
         */
        private function getFitsQB(int $id) : \Illuminate\Database\Query\Builder {
            return DB::table("fits")
                     ->where("ID", $id);
        }


        /**
         * @param array $id
         * @param     $name
         * @return PersonalDaily
         */
        public function getFitPopularityChart(array $ids, $name): PersonalDaily {

            $dates = [];
            for($i=-90; $i<=0; $i++) {
                $dates[] = date("M.d.", strtotime("now $i days"));
            }
            $pop = new PersonalDaily();
            $pop->displayAxes(true);
            $pop->export(true, "Download");
            $pop->height(300);
            $pop->theme(ThemeController::getChartTheme());
            $pop->displayLegend(true);
            $pop->labels($dates);
            $pop->load(route("chart.fit.popularity", ['ids' => json_encode($ids), 'name' => $name]));
            $pop->options([
                'tooltip' => [
                    'trigger' => "axis"
                ]
            ]);
            return $pop;
        }


        /**
         * @param string $ffh
         * @param bool   $includePrivate
         *
         * @return mixed
         */
        public function getSimilarFitsAsIdList(string $ffh, bool $includePrivate = false) {
            $query = DB::table("fits")
                ->where("FFH", $ffh);
            if (!$includePrivate) {
                $query->where("PRIVACY", "!=", 'private');
            }
            $ids = $query->select("ID")->get();
            return \Arr::pluck($ids, "ID");
        }


        public function getFitsFromIds(array $ids) {
            $fits = $this->fitSearchController->getStartingQuery()->whereIn("fits.ID", $ids)->get();

            foreach ($fits as $i => $result) {
                $fits[$i]->TAGS = $this->fitSearchController->getFitTags($result->ID);
            }
            return $fits;
        }

        /**
         * @param int $id
         * @return LootAveragesChart
         */
        public function getFitLootStrategyChart(array $ids): LootAveragesChart {

            $loot_chart = new LootAveragesChart();
            $loot_chart->displayAxes(false);
            $loot_chart->export(true, "Download");
            $loot_chart->height(400);
            $loot_chart->theme(ThemeController::getChartTheme());
            $loot_chart->displayLegend(true);
            $loot_chart->load(route("chart.fit.loot-strategy", ['ids' => json_encode($ids)]));
            return $loot_chart;
        }
    }
