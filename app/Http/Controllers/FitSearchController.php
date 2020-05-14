<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\EFT\Tags\TagsController;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitSearchController extends Controller {

        /** @var TagsController */
        private $tags;

        /**
         * FitSearchController constructor.
         *
         * @param TagsController $tags
         */
        public function __construct(TagsController $tags) {
            $this->tags = $tags;
        }


        /**
         * Handles the homescreen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            $ships = Cache::remember("aft.ships", now()->addHour(), function() {return DB::table("ship_lookup")->orderBy("NAME", "ASC")->get();});
            $groups = Cache::remember("aft.ship.groups", now()->addHour(), function () {return DB::select("select distinct `GROUP` from ship_lookup order by 1 asc");});
            $results = $this->getStartingQuery()->orderByDesc("RUNS_COUNT")->paginate();

            foreach ($results as $i => $result) {
                $results[$i]->TAGS = $this->getFitTags($result->ID);
            }
            $users = Cache::remember("aft.chars_with_public_fits", now()->addMinutes(5), function() {return DB::select("select distinct f.CHAR_ID as CHAR_ID, c.NAME NAME from fits f join chars c on f.CHAR_ID = c.CHAR_ID where f.PRIVACY='public' order by c.NAME;");});
            return view("components.fits.list", [
                'ships' => $ships,
                'shipGroups' => $groups,
                'results' => $results,
                'users' => $users
            ]);
        }

        /**
         * Handles the search view
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function search(Request $request) {
            $ships = Cache::remember("aft.ships", now()->addHour(), function() {return DB::table("ship_lookup")->orderBy("NAME", "ASC")->get();});
            $groups = Cache::remember("aft.ship.groups", now()->addHour(), function () {return DB::select("select distinct `GROUP` from ship_lookup order by 1 asc");});
            [$query, $filters_display] = $this->getSearchQuery($request);

            $filters =  $request->all();
            $query->orderByDesc("RUNS_COUNT")->get();
//            dd(DB::getQueryLog());
            Log::info(print_r(DB::getQueryLog(), 1));
            $results = $query->orderByDesc("RUNS_COUNT")->paginate();

            foreach ($results as $i => $result) {
                $results[$i]->TAGS = $this->getFitTags($result->ID);
            }
            return view("components.fits.results", [
                'ships' => $ships,
                'shipGroups' => $groups,
                'results' => $results,
                'filters' =>  $filters_display]);
        }



        /**
         * @param int $id
         *
         * @return mixed
         */
        public function getFitTags(int $id) {
            return Cache::remember("aft.fits.tags.$id", now()->addSeconds(30), function () use ($id) {
                return DB::table("fit_tags")
                         ->where("FIT_ID", $id)
                         ->get();
            });
        }

        /**
         * Gets the starting query
         * @return \Illuminate\Database\Query\Builder
         */
        public function getStartingQuery(): Builder {
            return DB::table("fits")
                     ->where("PRIVACY", '!=', 'private')
                     ->where("STATUS", 'done')
                     ->join("ship_lookup", 'fits.SHIP_ID', '=', 'ship_lookup.ID')
                     ->join("fit_recommendations", 'fits.ID', '=', 'fit_recommendations.FIT_ID')

                     ->select(["fits.ID",
                               "fits.SHIP_ID",
                               "fits.NAME",
                               "fits.STATS",
                               "fits.PRICE",
                               "fits.VIDEO_LINK",
                               "ship_lookup.NAME as SHIP_NAME", DB::raw('(select count(runs.`ID`) from `runs` where runs.`FIT_ID`=fits.`ID`) as `RUNS_COUNT`'),
                               "fit_recommendations.DARK",
                               "fit_recommendations.ELECTRICAL",
                               "fit_recommendations.EXOTIC",
                               "fit_recommendations.FIRESTORM",
                               "fit_recommendations.GAMMA"])
                     ->distinct("fits.ID");
        }/**
     * @param Request $request
     *
     * @return array
     */
        protected function getSearchQuery(Request $request) : array {
            DB::enableQueryLog();
            /** @var Builder $query */
            $query = $this->getStartingQuery();
            $filters_display = collect([]);
            if ($request->filled("TYPE") && !$request->filled("TIER")) {
                $query->where("fit_recommendations." . strtoupper($request->get("TYPE")), '>', 0);
                $filters_display->add("Good for " . $request->get("TYPE") . " runs");
            }
            if ($request->filled("TIER")) {
                $tier = $request->get("TIER");

                if ($request->filled("TYPE")) {
                    $query->where("fit_recommendations." . $request->get("TYPE"), '>=', $tier);
                    $filters_display->add("For at least Tier " . $request->get("TIER") . " " . $request->get("TYPE") . " runs");
                } else {
                    $query->whereRaw("(
                    fit_recommendations.DARK>=" . intval($tier) . " OR
                    fit_recommendations.ELECTRICAL>=" . intval($tier) . " OR
                    fit_recommendations.EXOTIC>=" . intval($tier) . " OR
                    fit_recommendations.FIRESTORM>=" . intval($tier) . " OR
                    fit_recommendations.GAMMA>=" . intval($tier) . "
                    )");
                    $filters_display->add("Can do a tier " . $request->get("TIER") . " run or more difficult");
                }
            }
            if ($request->filled("CHAR_ID")) {
                $query->where("fits.CHAR_ID", '=', $request->get("CHAR_ID"))
                      ->where("fits.PRIVACY", '=', 'public');
                $filters_display->add("Uploaded by " . DB::table('chars')
                                                         ->where('CHAR_ID', '=', $request->get("CHAR_ID"))
                                                         ->value('NAME'));
            }
            if ($request->filled("NAME")) {
                $query->where("fits.NAME", 'like', '%' . $request->get("NAME") . '%');
                $filters_display->add("Fit name '" . $request->get("NAME") . "'");
            }
            if ($request->filled("CHEAPER_THAN")) {
                $query->where("fits.PRICE", '<=', intval($request->get("CHEAPER_THAN")) * 1000000);
                $filters_display->add("Cheaper than " . number_format(intval($request->get("CHEAPER_THAN")) * 1000000, 0, ",", " ") . " ISK");
            }
            if ($request->filled("SHIP_ID")) {
                $query->where("fits.SHIP_ID", '=', $request->get("SHIP_ID"));
                $filters_display->add(DB::table('ship_lookup')
                                        ->where('ID', '=', $request->get("SHIP_ID"))
                                        ->value('NAME') . " fits");
            }

            $tagList = $this->tags->getTagList();
            foreach ($tagList as $tag) {
                if ($request->filled($tag)) {
                    $query = $this->filterForTag($tag, $request, $query);
                    $filters_display->add($this->labelForTag($tag, $request));
                }
            }

            return [$query, $filters_display];
        }

        /**
         * Creates a join for a specified tag
         * @param string  $tagName Tag name
         * @param Request $request Entire request
         * @param Builder $query Existing query builder
         *
         * @return Builder Expanded query builder
         */
        private function filterForTag(string $tagName, Request $request, Builder $query): Builder {
            /** @var Builder $query */
            return $query->join("fit_tags as " .$tagName, 'fits.ID', '=', $tagName.'.FIT_ID')
                         ->where($tagName.".TAG_NAME", '=', $tagName)
                         ->where($tagName.".TAG_VALUE", '=', $request->get($tagName) == "yes" ? 1 : 0);
        }

        /**
         * @param string  $tagName
         * @param Request $request
         *
         * @return string
         */
        private function labelForTag(string $tagName, Request $request): string {
            return ($request->get($tagName) == "yes" ? __("tags.show-only") : __("tags.exclude")) . " " . strtolower(__("tags.".$tagName));
        }

    }





