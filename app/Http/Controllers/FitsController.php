<?php


	namespace App\Http\Controllers;


	use App\Charts\LootAveragesChart;
    use App\Charts\PersonalDaily;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\DS\FitBreakEvenCalculator;
    use App\Http\Controllers\DS\FitAdvancedStatsCalculator;
    use App\Http\Controllers\EFT\DTO\Eft;
    use App\Http\Controllers\EFT\FitHelper;
    use App\Http\Controllers\EFT\FitHistoryController;
    use App\Http\Controllers\EFT\FitParser;
    use App\Http\Controllers\EFT\ItemPriceCalculator;
    use App\Http\Controllers\EFT\Tags\TagsController;
    use App\Http\Controllers\Partners\EveWorkbench;
    use App\Http\Controllers\Youtube\YoutubeController;
    use Arr;
    use ChrisKonnertz\OpenGraph\OpenGraph;
    use Cohensive\Embed\Embed;
    use Exception;
    use Illuminate\Contracts\Foundation\Application;
    use Illuminate\Contracts\View\Factory;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Http\RedirectResponse;
    use Illuminate\Http\Request;
    use Illuminate\Routing\Redirector;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Validator;
    use Illuminate\Support\Str;
    use Illuminate\Validation\ValidationException;
    use Illuminate\View\View;
    use Parsedown;
    use RuntimeException;

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
         *
         * @return Factory|View
         */
        public function new(int $id = null) {

            if (!$id) {
                $oldFitId = null;
                $oldFitName = null;
            }
            else {
                $fit = DB::table("fits")->where("ID", $id)->first();
                if ($fit->CHAR_ID != AuthController::getLoginId()) {
                    return view('403', ['error' => "You cannot update someone else's fit."]);
                }
                if (!$fit) {
                    return view('error', ['error' => "Fit does not exist."]);
                }

                $oldFitId = $id;
                $oldFitName = $fit->NAME;
            }


            return view("new_fit", [
                'oldFitId' => $oldFitId,
                'oldFitName' => $oldFitName
            ]);
	    }

        /**
         * Handles fit deletion
         *
         * @param int $id
         *
         * @return Factory|View
         */
        public function delete(int $id) {
            if (!session()->has("login_id")) {
                return view("403", ["error" => "Please sign in first"]);
            }
            $fit = DB::table("fits")->where("ID", $id)->first();

            if ($fit->CHAR_ID != AuthController::getLoginId()) {
                return view('403', ['error' => sprintf("You cannot delete someone else's fit.")]);
            }

            try {
                DB::beginTransaction();
                $ids = DB::table('fit_questions')->where('fit_id', $id)->select('id')->get()->pluck('fit_id');
                DB::table("fit_answers")->whereIn("question_id", $ids)->delete();
                DB::table("fit_logs")->where("fit_root_id", $id)->delete();
                DB::table("fit_logs")->where("fit_it", $id)->delete();
                DB::table("fit_questions")->where("fit_id", $id)->delete();
                DB::table("fit_tags")->where("FIT_ID", $id)->delete();
                DB::table("fit_recommendations")->where("FIT_ID", $id)->delete();
                DB::table("fits")->where("ID", $id)->where("CHAR_ID",  AuthController::getLoginId())->delete();
                DB::commit();
                return view("autoredirect", ['title' => "Fit deleted", 'message' =>"The fit and all its data was removed from the Abyss Tracker.", "redirect" => route("fit.mine")]);
            }
            catch (Exception $e) {
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
         * @return Factory|RedirectResponse|Redirector|View
         */
        public function changePrivacy(int $id, string $privacySetting) {

            Validator::make(['id' => $id, 'status' => $privacySetting], [
                'id'  => 'required|numeric|exists:fits,ID',
                'status' => 'required|in:public,incognito,private'
            ], [
                'required' => "Please fill :attribute",
            ])->validate();

            if (!session()->has("login_id")) {
                return view("403", ["error" => "Please sign in first"]);
            }
            $fit = DB::table("fits")->where("ID", $id)->first();

            if (!AuthController::isItMe($fit->CHAR_ID)) {
                return view('error', ['title' => "Not allowed", 'error' => sprintf("You cannot modify someone else's fit.")]);
            }

            try {

                DB::beginTransaction();
                FitHistoryController::addEntry($id, "Updated privacy to $privacySetting");
                DB::table("fits")->where("ID", $id)->where("CHAR_ID", session()->get("login_id"))->update([
                    'PRIVACY' => $privacySetting
                ]);
                DB::commit();
                self::uncache($id);
                return view('autoredirect', [
                    'title' => "Success",
                    'message' => "Privacy changed to $privacySetting",
                    'redirect' => route('fit_single', ['id' => $id])
                ]);
            }
            catch (Exception $e) {
                DB::rollBack();
                Log::error("Transaction rolled back - Could not change fit privacy $id - ".$e->getMessage(). " ".$e->getFile()."@".$e->getLine());
                return view("error", ["error" => "Something went wrong and could not change privacy. Modifications reverted."]);
            }
        }

        /**
         * @param Request $request
         *
         * @return Factory|RedirectResponse|Redirector|View
         * @throws Exception
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
                'privacy' => 'required',
                'rootId' => 'numeric|exists:fits,ID'
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
                    throw ValidationException::withMessages([
                        'ELECTRICAL' => ['Please mark at least one type/tier possible in this fit.']
                    ]);
                }

                $charId = AuthController::getLoginId();
                if ($request->has('rootId')) {
                    if (!DB::table('fits')->where('ID', $request->get('rootId'))->where('CHAR_ID', $charId)->exists()) {
                        throw ValidationException::withMessages([
                            'rootId' => ["You must not update someone else\'s fit"]
                        ]);
                    }
                }

                $eft = $request->get("eft");
                $shipId = self::getShipIDFromEft($eft);

                if (!DB::table("ship_lookup")->where("ID", $shipId)->exists()) {
                    throw new Exception("Please select a ship that is allowed to enter the Abyssal Deadspace");
                }

                $fitObj = $this->fitParser->getFitTypes($eft);
                $totalPrice = $fitObj->getFitValue(); // Let's get this before the DB transaction starts

                $hash = $this->fitHelper->getFitFFH($eft);

                if ($request->filled("fitName")) {
                    $fitObj->setFitName($request->get("fitName"));
                }

                DB::beginTransaction();
                $id = DB::table("fits")->insertGetId([
                    'CHAR_ID' => $charId,
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
                    'ROOT_ID' => $request->get('rootId', null)
                ]);

                if (!$this->submitSvcFitService($this->fitHelper->pyfaBugWorkaround($eft, $shipId), $id)) {
                    throw new RuntimeException("The Abyss Tracker fit calculation tool refused to parse this EFT. This is often caused by a mistake in copy pasting, or a typo.");
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

                if ($request->has('rootId')) {
                    FitHistoryController::addEntry($id, "This fit was updated.");
                }
                else {
                    FitHistoryController::addEntry($id, "Fit submitted to the Abyss Tracker");
                }

                DB::commit();
            }
            catch (Exception $e) {
                DB::rollBack();
                Log::error("Error while saving new fit: ".$e->getMessage()." ".$e->getFile()."@".$e->getLine());
                return view('error', ['error' => "Could not save fit: ".$e->getMessage()]);
            }

            return redirect(route('fit_single', ['id' => $id]));
	    }


        /**
         * Handles updating the description for a fit
         *
         * @param Request $request
         *
         * @return Application|Factory|View
         * @throws ValidationException
         */
        public function updateDescription(Request $request) {

            Validator::make($request->all(), [
                'id'  => 'required|numeric|exists:fits,ID',
                'description' => 'required'
            ], [
                'required' => "Please fill :attribute",
            ])->validate();


            $id = $request->get('id');
            $fit = DB::table("fits")->where("ID", $id)->select(['CHAR_ID', 'NAME'])->first();

            if (!AuthController::isItMe($fit->CHAR_ID)) {
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

                self::uncache($id);
            }
            catch (Exception $e) {
                Log::error("Could not update description for $id ". $e->getMessage()." ".$e->getTraceAsString());
                return view("error", ["error" => "Something went wrong while updating description, sorry. ".$e->getMessage()]);
            }


            // Redirect with message
            return view('autoredirect', [
                'title' => "Success",
                'message' => "The description of ".$fit->NAME." fit was updated",
                'redirect' => route('fit_single', ['id' => $id])
            ]);
	    }




        /**
         * Handles updating the description for a fit
         *
         * @param Request $request
         *
         * @return Application|Factory|View
         * @throws ValidationException
         */
        public function updateVideo(Request $request) {
            Validator::make($request->all(), [
                'id'  => 'required|numeric|exists:fits,ID'
            ], [
                'required' => "Please fill :attribute"
            ])->validate();


            $id = $request->get('id');
            $fit = DB::table("fits")->where("ID", $id)->select(['CHAR_ID', 'NAME'])->first();

            if (!AuthController::isItMe($fit->CHAR_ID)) {
                return view('403', ['error' => sprintf("You cannot modify someone else's fit.")]);
            }


            $regex_pattern = config('tracker.verification.youtube');
            // If YT regex test fails
            if (!Str::of($request->get('video'))->match($regex_pattern)->isNotEmpty()) {
                throw ValidationException::withMessages(['video' => "Please provide a proper Youtube link"]);
            }

            // Actually edit
            DB::beginTransaction();
            try {
                DB::table('fits')
                  ->where('id', $id)
                  ->update(['VIDEO_LINK' => $request->filled('video') ? $request->get('video') : null]);

                // Write history
                FitHistoryController::addEntry($id, "Updated video link");
                DB::commit();

                self::uncache($id);
            }
            catch (Exception $e) {
                Log::error("Could not update description for $id ". $e->getMessage()." ".$e->getTraceAsString());
                return view("error", ["error" => "Something went wrong while updating the tutorial video, sorry. ".$e->getMessage()]);
            }


            // Redirect with message
            return view('autoredirect', [
                'title' => "Success",
                'message' => "The tutorial video of ".$fit->NAME." fit was updated",
                'redirect' => route('fit_single', ['id' => $id])
            ]);
        }




        /**
         * @param Request $request
         *
         * @param int     $id
         * @param string  $status
         *
         * @return Application|Factory|View
         */
        public function updateLastPatch(Request $request, int $id, string $status) {

            Validator::make(['id' => $id, 'status' => $status], [
                'id'  => 'required|numeric|exists:fits,ID',
                'status' => 'required|in:works,untested,deprecated'
            ], [
                'required' => "Please fill :attribute",
            ])->validate();

            $fit = DB::table("fits")->where("ID", $id)->select(['CHAR_ID', 'NAME'])->first();

            if ($fit->CHAR_ID != AuthController::getLoginId()) {
                return view('403', ['error' => sprintf("You cannot modify someone else's fit.")]);
            }

            // Actually edit
            DB::beginTransaction();
            try {
                DB::table('fits')
                  ->where('id', $id)
                  ->update(['LAST_PATCH' => $status]);

                // Write history
                FitHistoryController::addEntry($id, "Updated status to ".__('tags.'.$status));
                DB::commit();
                self::uncache($id);
            }
            catch (Exception $e) {
                Log::error("Could not update description for $id ". $e->getMessage()." ".$e->getTraceAsString());
                return view("error", ["error" => "Something went wrong while updating last patch status, sorry. ".$e->getMessage()]);
            }


            // Redirect with message
            return view('autoredirect', [
                'title' => "Success",
                'message' => "The patch status of ".$fit->NAME." fit was updated to ".__('tags.'.$status),
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
         * @return Factory|View
         * @throws Exception
         */
        public function get(int $id) {
            clock()->event("Checking if exists", "")->begin();
                if (!$this->getFitsQB($id)
                          ->exists()) {
                    clock()->event("Checking if exists")->end();
                    return view('error', ['error' => sprintf("Can not find a fit with ID %d", $id)]);
                }
            clock()->event("Checking if exists")->end();

            try {

                // Get the fit - with some caching
                clock()->event("Getting the fit from DB", "")->begin();
                $fit = Cache::remember("aft.fit-record-full.".$id, now()->addSeconds(15), function () use ($id) {
                    return $this->getFitsQB($id)->first();
                });
                clock()->event("Getting the fit from DB")->end();


                // Check credentials
                clock()->event("Checking privacy", "")->begin();
                if ($fit->PRIVACY == 'private' && $fit->CHAR_ID != AuthController::getLoginId()) {
                    return view('403', ['error' => sprintf("<p class='mb-0'>This is a private fit. <br> <a class='btn btn-link mt-3' href='" . route('fit.search') . "'>View public fits</a></p>")]);
                }
                clock()->event("Checking privacy")->end();

                // Get ship name and character name
                clock()->event("Lookup ship name and character name", "")->begin();
                $ship_name = DB::table('ship_lookup')
                               ->where('ID', $fit->SHIP_ID)
                               ->value('NAME');
                $char_name = DB::table('chars')
                               ->where('CHAR_ID', $fit->CHAR_ID)
                               ->value('NAME');
                clock()->event("Lookup ship name and character name")->end();

                // Parse description, get ship type ID and ship name
                clock()->event("Parse description", "")->begin();
                $description = (new Parsedown())->setSafeMode(true)->parse($fit->DESCRIPTION);
                clock()->event("Parse description")->end();

                clock()->event("Get ship type ID", "")->begin();
                $shipType = DB::table("ship_lookup")->where("ID", $fit->SHIP_ID)->value("GROUP") ?? "Unknown type";
                clock()->event("Get ship type ID")->end();

                clock()->event("Get shipitemObject", "")->begin();
                $shipitemObject = $this->sipc->getFromTypeId($fit->SHIP_ID);
                if (!$shipitemObject) {
                    throw new Exception("Could not find the ship name from the ship ID (".$fit->SHIP_ID.") - This happens frequently during EVE downtime and will solve itself when EVE comes back online");
                }
                clock()->event("Get shipitemObject")->end();

                // Get ship price
                clock()->event("Get ship price", "")->begin();
                $shipPrice = $shipitemObject->getAveragePrice() ?? 0.0;
                clock()->event("Get ship price")->end();

                // Get video link
                clock()->event("Parse fit video link", "")->begin();
                if (trim($fit->VIDEO_LINK)) {
                    try {
                        $embed = YoutubeController::getEmbed($fit->VIDEO_LINK);
                    } catch (Exception $exception) {
                        Log::warning(sprintf("Could not generate embed for %s", $fit->VIDEO_LINK));
                        $embed = "<div class='alert alert-warning'>Could not generate embed for link: " . htmlentities($fit->VIDEO_LINK) . '</div>';
                    }
                } else { $embed = "";}
                clock()->event("Parse fit video link")->end();

                // Get recommendations
                clock()->event("Load fit recommendations", "")->begin();
                $recommendations = DB::table("fit_recommendations")->where("FIT_ID", $id)->first();
                clock()->event("Load fit recommendations")->end();

                // Make open graph tags
                clock()->event("Generate Open Graph tags", "")->begin();
                $og = new OpenGraph();
                $tags = TagsController::getFitTags($id);
                $og->title(sprintf("%s fit - %s", $ship_name, config('app.name')))
                   ->type('profile')
                   ->description(sprintf("%s fit with %s on %s", $ship_name, $tags->join(", ", ", and "), config('app.name')))
                   ->url()
                   ->locale('en_US')
                   ->localeAlternate(['en_UK'])
                   ->siteName(config('app.name'))
                   ->determiner('an')
                   ->image("https://images.evetech.net/types/$fit->SHIP_ID/render?size=256", ['width' => 256, 'height' => 256]);
                $og->profile(["first_name" => trim($fit->NAME)]);
                clock()->event("Generate Open Graph tags")->end();

                // Get last runs with this fit
                clock()->event("Load fit's saved runs", "")->begin();
                $runs = DB::table("runs")
                  ->where("FIT_ID", $id)
                  ->orderBy("CREATED_AT", 'DESC')
                  ->paginate(25);
                clock()->event("Load fit's saved runs")->end();

                // Get max tiers and "break even" stats
                clock()->event("'Break even calculation' - determine max tiers", "")->begin();
                $maxTiers = FitBreakEvenCalculator::getMaxTiers($id);
                clock()->event("'Break even calculation' - determine max tiers")->end();
                clock()->event("'Break even calculation' - calculate break even time", "")->begin();
                $breaksEven = FitBreakEvenCalculator::breaksEvenCalculation($id, $maxTiers, $fit);
                clock()->event("'Break even calculation' - calculate break even time")->end();


                // Get parsed items and price
                clock()->event("Load EFT from ID", "")->begin();
                $eftObj = Eft::loadFromId($id);
                clock()->event("Load EFT from ID")->end();
                clock()->event("Load structured, pre-parsed display", "")->begin();
                $eftParsed = $eftObj->getStructuredDisplay();
                clock()->event("Load structured, pre-parsed display")->end();
                clock()->event("Calculate fit value", "")->begin();
                $fit->PRICE = $eftObj->getFitValue();
                $this->getFitsQB($id)->update(["PRICE" => $fit->PRICE]);
                clock()->event("Calculate fit value")->end();

                // Get similar fits
                clock()->event("Get similar fits", "")->begin();
                $fitIdsAll = $this->getSimilarFitsAsIdList($fit->FFH, true);
                $fitIdsNonPrivate = $this->getSimilarFitsAsIdList($fit->FFH, false);
                $similars = $this->getFitsFromIds($fitIdsNonPrivate);
                clock()->event("Get similar fits")->end();

                clock()->event("Make charts", "")->begin();
                $popularity = $this->getFitPopularityChart($fitIdsAll, "Fit");
                $loots = $this->getFitLootStrategyChart($fitIdsAll);
                clock()->event("Make charts")->end();

                // Get all runs count with this fit
                clock()->event("Count all runs", "")->begin();
                $runsCountAll = DB::table("runs")
                      ->where("FIT_ID", $id)
                      ->orderBy("CREATED_AT", 'DESC')->count();
                clock()->event("Count all runs")->end();

                // Get history
                clock()->event("Load history", "")->begin();
                $history = FitHistoryController::getFitHistory($id)->reverse();
                clock()->event("Load history")->end();

                // Check revisions history
                clock()->event("Load revision", "")->begin();
                $newestRevision = FitHistoryController::getLastRevision($id);
                clock()->event("Load revision")->end();

                // Check revisions history
                clock()->event("Load questions and answers", "")->begin();
                $questions = FitQuestionsController::getFitQuestions($id);
                clock()->event("Load questions and answers")->end();
                // Check revisions history
                clock()->event("Generate Eve Workbench export URL", "")->begin();
                $eveworkbenchLink = 'https://www.eveworkbench.com/import/fit/'.base64_encode(json_encode([
                        "name" => $fit->NAME,
                        "eft" => $fit->RAW_EFT,
                        "tags" => $tags->join(","),
                        "youtube_url" => $fit->VIDEO_LINK ?? ''
                    ]));
                clock()->event("Generate Eve Workbench export URL")->end();

                clock()->event("Generate Advanced Stats")->begin();

                $advanced_stats = FitAdvancedStatsCalculator::generate($id);

                clock()->event("Generate Advanced Stats")->end();

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
                    'history' => $history,
                    'lastRevision' => $newestRevision,
                    'questions' => $questions,
                    'eveworkbenchLink' => $eveworkbenchLink,
                    'advanced_stats' => $advanced_stats
                ]);

            }
            catch (Exception $e)  {
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
         * @throws Exception
         */
        public function submitSvcFitService(string $eft, int $fitId, string $idPrefix = null) {
            $ch = curl_init();

            curl_setopt($ch, CURLOPT_URL,config('fits.service-url'));
            curl_setopt($ch, CURLOPT_POST, true);

            $idPrefix = $idPrefix ?? config('fits.prefix.default');

            $query = http_build_query([
                'fit' => $eft,
                'appId' =>config('fits.auth.id'),
                'appSecret' => config('fits.auth.secret'),
                'fitId' => sprintf("%s:%d", $idPrefix, $fitId)
            ]);

            curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
            curl_setopt($ch, CURLOPT_VERBOSE, true);

            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            curl_close($ch);

            if (!$response) {
                throw new Exception("The fit stat service did not respond");
            }

            $responseData = json_decode($response, true);
            if (!$responseData) {
                Log::error("Invalid response from fit stat service: ".$responseData." for input ".$query);

                if ($idPrefix == config('fits.prefix.default')) {
                    FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
                }
                throw new Exception("The fit stat service returned malformed response");
            }

            if(!isset($responseData["success"])) {
                if ($idPrefix == config('fits.prefix.default')) {
                    FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
                }
                throw new RuntimeException("No 'status' key in SVCFITSTAT response: ".print_r($responseData, 1));
            }

            if ($responseData["success"]) {
                if ($idPrefix == config('fits.prefix.default')) {
                    FitHistoryController::addEntry($fitId, "Submitted fit for stats calculation");
                }
                Log::info("Submitted fit to svcfitstat.");
                return true;
            }
            else {
                if ($idPrefix == config('fits.prefix.default')) {
                    FitHistoryController::addEntry($fitId, "Could not submit fit for stats calculation.");
                }
                Log::error("Negative response input ".$query.": ".print_r($responseData, true));
                return false;
            }
	    }

        /**
         * @param string $fit
         *
         * @return mixed
         * @throws Exception
         */
        private function getFitName(string $fit): string {

            // Get lines
            $lines = explode("\n", trim($fit));

            // Get and strip the first line
            try {
                $shipName = explode(",", explode("[", $lines[0],2)[1], 2)[1];
                $shipName = str_replace("]", "", $shipName);
            }
            catch (Exception $e) {
                Log::warning("Could not extract the ship name from the EFT fit. ".$e->getMessage()." ".$e->getFile()." ".$e->getLine());
                throw new Exception("Could not extract the ship name from the EFT fit. ", 0, $e);
            }

            return $shipName;
	    }

        /**
         * @param string $fit
         *
         * @return mixed
         * @throws Exception
         */
        public static function getShipIDFromEft(string $fit, bool $ignoreAbyssLimits = false) {

            // Get lines
            $lines = explode("\n", trim($fit));

            // Get and strip the first line
            try {
                $shipName = explode(",", explode("[", $lines[0],2)[1], 2)[0];
            }
            catch (Exception $e) {
                Log::warning("Could not extract the ship name from the EFT fit. ".$e->getMessage()." ".$e->getFile()." ".$e->getLine());
                throw new Exception("Could not extract the ship name from the EFT fit. ", 0, $e);
            }

//            Log::debug("Found ship: ".$shipName);
            if (!$ignoreAbyssLimits) {
                $shipId = DB::table("ship_lookup")->where('NAME', ucfirst(strtolower($shipName)))->value('ID');

                if (!$shipId) {
                    throw new Exception("Broken ship fit, unsupported fit, or the selected ship cannot go into the Abyss.");
                }
            }
            else {
                /** @var ResourceLookupService $rls */
                $rls = resolve('App\Connector\EveAPI\Universe\ResourceLookupService');
                $shipId = $rls->itemNameToId($shipName);
            }

            return $shipId;
        }



        /**
         * @param int $id
         *
         * @return Builder
         */
        private function getFitsQB(int $id) : Builder {
            return DB::table("fits")
                     ->where("ID", $id);
        }


        /**
         * @param array $id
         * @param     $name
         * @return PersonalDaily
         */
        public function getFitPopularityChart(array $ids, $name): PersonalDaily {

            $dates = collect(DB::select("select d.day
from date_helper d
where d.day between (select min(ir.RUN_DATE) from runs ir where ir.FIT_ID in (".implode(",",$ids).")) and NOW()
order by d.day asc;
"));
            $pop = new PersonalDaily();
            $pop->displayAxes(true);
            $pop->export(true, "Download");
            $pop->height(300);
            $pop->theme(ThemeController::getChartTheme());
            $pop->displayLegend(true);
            $pop->labels($dates->pluck('day'));
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
            return Arr::pluck($ids, "ID");
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

        public static function uncache(int $id):void {
            Cache::forget("aft.fit-record-full.".$id);
        }
    }
