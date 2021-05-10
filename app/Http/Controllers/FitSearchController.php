<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\EFT\Tags\TagsController;
    use Illuminate\Database\Query\Builder;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Str;

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
         * Must be secured by middleware
         */
        public function getIntegratedTypeList(Request $request) {
            $myFits = Cache::remember("aft.my-fits", now()->addSeconds(30), function () {
                return DB::table("fits as f")
                        ->join("ship_lookup as l", "f.SHIP_ID","=","l.ID")
                        ->where("f.CHAR_ID", session()->get("login_id", 0))
                        ->select([
                            'l.ID as SHIP_ID',
                            'f.ID as FIT_ID',
                            'f.NAME as FIT_NAME',
                            'l.NAME as SHIP_NAME',
                            'l.GROUP as SHIP_CLASS'
                        ])->get();
            });

            $ships = Cache::remember("aft.ships-fits-all", now()->addMinute(), function () {
                $fits = DB::table("ship_lookup as l")
                                 ->leftJoin("fits as f", "l.ID", '=', 'f.SHIP_ID')
                                 ->where("f.CHAR_ID",'!=', session()->get("login_id", 0))
                                 ->whereIn("f.PRIVACY", ['public', 'incognito'])
                                 ->select([
                                     'l.ID as SHIP_ID',
                                     'f.ID as FIT_ID',
                                     'f.NAME as FIT_NAME',
                                     'l.NAME as SHIP_NAME',
                                     'l.GROUP as SHIP_CLASS'
                                 ])
                                 ->orderBy('l.NAME')
                                 ->orderBy('f.NAME');
                return DB::table("ship_lookup as s")
                  ->select([
                      's.ID as SHIP_ID',
                      DB::raw('\'\' as FIT_ID'),
                      DB::raw('\'\' as FIT_NAME'),
                      's.NAME as SHIP_NAME',
                      's.GROUP as SHIP_CLASS'
                  ])
                  ->union($fits)
                  ->orderBy(DB::raw(4))
                  ->orderBy(DB::raw(3))
                  ->get();
            });

            $mapper = function ($item, $key) {
                if ($item->FIT_NAME)
                    $item->FIT_NAME = strip_tags(trim($item->FIT_NAME));
                $item->id = json_encode([
                    'SHIP_ID' => $item->SHIP_ID,
                    'FIT_ID' => $item->FIT_ID
                ]);
                $item->text = sprintf("%s, %s", $item->SHIP_NAME, $item->FIT_NAME ? "" . $item->FIT_NAME : "without fit selected");
                return $item;
            };

            $myFits->map($mapper);
            $ships->map($mapper);

            if (Str::of($request->get('term', ''))->isNotEmpty()) {
                $filter = function ($item, $key) use ($request){
                    $term = mb_strtoupper($request->get('term', ""));
                    if (Str::contains(mb_strtoupper($item->SHIP_NAME), $term)) {
                        return true;
                    }
                    if (Str::contains(mb_strtoupper($item->FIT_NAME), $term)) {
                        return true;
                    }
                    if (Str::contains(mb_strtoupper($item->SHIP_CLASS), $term)) {
                        return true;
                    }


                    $regex = '/^'.(collect(preg_split( '//u', $term, null, PREG_SPLIT_NO_EMPTY))->map(function($item) {
                        return sprintf("%s\\w+", Str::upper($item));
                    })->implode("\\s")).'/';

                    if (preg_match($regex, mb_strtoupper($item->SHIP_NAME))) {
                        return true;
                    }
                    if (preg_match($regex, mb_strtoupper($item->FIT_NAME))) {
                        return true;
                    }
                    if (preg_match($regex, mb_strtoupper($item->SHIP_CLASS))) {
                        return true;
                    }

                    return false;
                };
                $myFits = $myFits->filter($filter);
                $ships = $ships->filter($filter);

                $highlight = function($item, $key) use ($request) {
                    $term = $request->get("term", "");
                    $item->SHIP_NAME = str_ireplace($term, "<span class='highlight'>".ucfirst($term)."</span>", $item->SHIP_NAME);
                    $item->FIT_NAME = str_ireplace($term, "<span class='highlight'>".ucfirst($term)."</span>", $item->FIT_NAME);
                    $item->SHIP_CLASS = str_ireplace($term, "<span class='highlight'>".ucfirst($term)."</span>", $item->SHIP_CLASS);

                    return $item;
                };

                $myFits->map($highlight);
                $ships->map($highlight);
            }

            return [
                'results' => [
                    ['id' => json_encode(['SHIP_ID' => null, 'FIT_ID' => null]), "text" => "Not specified", "SHIP_ID" => 0, "FIT_ID" => "", "SHIP_NAME" => "Not specified", "SHIP_CLASS" => "", "FIT_NAME" => ""],
                    ['text' => "My fits", 'children' => $myFits->values()],
                    ['text' => "All ships and public fits", 'children' => $ships->values()],
                ],
                'pagination' => [
                    'more' => false
                ]
            ];
        }


        /**
         * @param             $thing
         * @param bool        $disabled
         * @param string|null $nameOverride
         * @param int|null    $idOverride
         *
         * @param bool|null   $isSelected
         *
         * @return array
         */
        private function getFitSelect($thing, bool $disabled = false, string $nameOverride = null, $idOverride=null, bool $isSelected = null) {
            return [
                'id' => $idOverride ?? intval($thing->ID),
                'text' => $nameOverride ?? sprintf("%s (Fit #%s)", trim($thing->NAME), $thing->ID),
                'disabled' => $disabled,
                'selected' => $isSelected
            ];
        }

        /**
         * Handles the homescreen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            $ships = Cache::remember("aft.ships", now()->addHour(), function() {return DB::table("ship_lookup")->whereRaw("ship_lookup.ID in (select SHIP_ID from fits)")->orderBy("NAME", "ASC")->get();});
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
         * Handles the homescreen
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function mine() {

            $results = $this->getStartingQuery(false)->where("fits.CHAR_ID",session()->get("login_id"))
                            ->orderByDesc("RUNS_COUNT")->get();

            foreach ($results as $i => $result) {
                $results[$i]->TAGS = $this->getFitTags($result->ID);
            }
            return view("components.fits.mine-list", [
                'results' => $results
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
            $query->orderByDesc("RUNS_COUNT")->get();
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
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function searchAjax(Request $request) {
            /** @var Builder $query */
            [$query, $filters_display] = $this->getSearchQuery($request);
            $query->orderByDesc("RUNS_COUNT")->get();
            $results = $query->orderByDesc("RUNS_COUNT")->limit(50)->get();

            foreach ($results as $i => $result) {
                $results[$i]->TAGS = $this->getFitTags($result->ID);
            }
            return view("components.fits.result-ajax", [
                'results' => $results, 'filters' => $filters_display]);
        }


        /**
         * @param int $id
         *
         * @return mixed
         */
        public function getFitTags(int $id) {
            return Cache::remember("aft.fits.tags.$id", now()->addSeconds(120), function () use ($id) {
                return DB::table("fit_tags")
                         ->where("FIT_ID", $id)
                         ->get();
            });
        }

        /**
         * Gets the starting query
         *
         * @param bool $excludePrivate
         *
         * @return \Illuminate\Database\Query\Builder
         */
        public function getStartingQuery(bool $excludePrivate = true): Builder {
            $query = DB::table("fits")
                     ->where("STATUS", 'done')
                     ->join("ship_lookup", 'fits.SHIP_ID', '=', 'ship_lookup.ID')
                     ->join("fit_recommendations", 'fits.ID', '=', 'fit_recommendations.FIT_ID')

                     ->select(["fits.ID",
                               "fits.SHIP_ID",
                               "fits.NAME",
                               "fits.STATS",
                               "fits.PRICE",
                               "fits.VIDEO_LINK",
                               "ship_lookup.NAME as SHIP_NAME",
                               DB::raw('(select count(runs.`ID`) from `runs` where runs.`FIT_ID`=fits.`ID` and runs.RUN_DATE >= DATE_SUB(NOW(), INTERVAL 30 DAY)) as `RUNS_COUNT`'),
                               "ship_lookup.GROUP",
                               "fit_recommendations.DARK as Dark",
                               "fit_recommendations.ELECTRICAL as Electrical",
                               "fit_recommendations.EXOTIC as Exotic",
                               "fit_recommendations.FIRESTORM as Firestorm",
                               "fit_recommendations.GAMMA as Gamma",
                               "fits.SUBMITTED as Submitted",
                               "fits.PRIVACY",
                               "fits.LAST_PATCH"])
                     ->distinct("fits.ID");
            if ($excludePrivate) {
                $query->where("PRIVACY", '!=', 'private');
            }
            return $query;
        }

        /**
     * @param Request $request
     *
     * @return array
     */
        protected function getSearchQuery(Request $request) : array {
//            DB::enableQueryLog();
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
                    fit_recommendations.DARK=" . intval($tier) . " OR
                    fit_recommendations.ELECTRICAL=" . intval($tier) . " OR
                    fit_recommendations.EXOTIC=" . intval($tier) . " OR
                    fit_recommendations.FIRESTORM=" . intval($tier) . " OR
                    fit_recommendations.GAMMA=" . intval($tier) . "
                    )");
                    $filters_display->add("Rated for tier " . $request->get("TIER"));
                }
            }
            if ($request->filled("CHAR_ID")) {
                $query->where("fits.CHAR_ID", '=', $request->get("CHAR_ID"))
                      ->where("fits.PRIVACY", '=', 'public');
                $filters_display->add("Uploaded by " . DB::table('chars')
                                                         ->where('CHAR_ID', '=', $request->get("CHAR_ID"))
                                                         ->value('NAME') ?? "Unregistered user");
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


            if ($request->filled("SHIP_IS_CRUISER")) {
                $query->where("ship_lookup.HULL_SIZE", '=', $request->get("SHIP_IS_CRUISER"));
                $filters_display->add(ucfirst($request->get("SHIP_IS_CRUISER"))." size ships");
            }
            if ($request->filled("SHIP_GROUP")) {
                $query->where("ship_lookup.GROUP", '=', $request->get("SHIP_GROUP"));
                $filters_display->add($request->get("SHIP_GROUP")." class");
            }

            if ($request->filled("ORDER_BY")) {
                $query->orderBy($request->get("ORDER_BY"), $request->get("ORDER_BY_ORDER") ?? "ASC");
                $filters_display->add("Order by ".__("fits.order-by.".strtolower($request->get("ORDER_BY")))." in ".($request->get("ORDER_BY_ORDER") == "desc" ? "descending" : "ascending")." order");
            }
            else {
                $filters_display->add("Most popular first");
            }

            if ($request->filled("MIN_USES")) {
//                $query->where("ship_lookup.GROUP", '=', $request->get("SHIP_GROUP"));
                $query->having("RUNS_COUNT",">=",$request->get("MIN_USES"));
                $filters_display->add("Has at least ".$request->get("MIN_USES")." runs recorded");
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
         * @return mixed
         */
        public function getHomepagePopularFits() {
            return Cache::remember("aft.home.fits.popular", now()->addMinutes(15), function() {
                $query = $this->getStartingQuery()
                                                   ->limit(config('tracker.homepage.fits.count'))
                                                   ->orderByDesc("RUNS_COUNT");
                $popularFits = $query->get();
                foreach ($popularFits as $i => $result) {
                    $popularFits[$i]->TAGS = $this->getFitTags($result->ID);
                }
                return $popularFits;
            });
        }


        /**
         * @return mixed
         */
        public function getHomepageNewFits() {
            return Cache::remember("aft.home.fits.new", now()->addMinutes(15), function() {
                $query = $this->getStartingQuery()
                                                   ->limit(config('tracker.homepage.fits.count'))
                                                   ->orderBy('SUBMITTED', 'ASC');
                $popularFits = $query->get();
                foreach ($popularFits as $i => $result) {
                    $popularFits[$i]->TAGS = $this->getFitTags($result->ID);
                }
                return $popularFits;
            });
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


        /**
         * @param $prev
         *
         * @return string
         */
        public static function getLastSelected($prev) : array {
            if (!isset($prev->SHIP_ID)) {
                return ['id' => json_encode(['SHIP_ID' => null, 'FIT_ID' => null]), 'text' => 'Welcome! Click here to select a ship/fit.'];
            }
            else {
                $shipName = DB::table("ship_lookup")
                           ->where('ID', $prev->SHIP_ID)
                           ->value('NAME');
                $fitSelected = $prev->FIT_ID != null;
                $fitName = DB::table("fits")
                         ->where('ID', $prev->FIT_ID)
                         ->value('NAME') ?? ($fitSelected ? "Deleted fit" : "No fit selected");
            }
            return ['id' => json_encode(['SHIP_ID' => $prev->SHIP_ID, 'FIT_ID' => $prev->FIT_ID]), 'text' => "Last used: " . ($shipName ?? "No ship selected") . "/" . ($fitName) . " ".($fitSelected ? "(Fit ID #".$prev->FIT_ID.")" : "")];
        }
    }





