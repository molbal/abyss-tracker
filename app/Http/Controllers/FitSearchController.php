<?php


    namespace App\Http\Controllers;


    use App\Http\Controllers\EFT\Tags\TagsController;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

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


        public function index() {
            $ships = DB::table("ship_lookup")
                       ->orderBy("NAME", "ASC")
                       ->get();
            $groups = Cache::remember("aft.ship.groups", now()->addHour(), function () {
                return DB::select("select distinct `GROUP` from ship_lookup order by 1 asc");
            });
            $results = $this->getStartingQuery()->orderByDesc("RUNS_COUNT")->paginate();
            foreach ($results as $i => $result) {
                $results[$i]->TAGS = $this->getFitTags($result->ID);
            }

            return view("components.fits.list", ['ships' => $ships, 'shipGroups' => $groups, 'results' => $results]);
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

        public function getOrderBy() {
        }

        public function getStartingQuery() {
            return DB::table("fits")
                     ->where("PRIVACY", '!=', 'private')
                     ->where("STATUS", 'done')
                     ->join("ship_lookup", 'fits.SHIP_ID', '=', 'ship_lookup.ID')
                     ->join("fit_recommendations", 'fits.ID', '=', 'fit_recommendations.FIT_ID')
                     ->join("fit_tags", 'fits.ID', '=', 'fit_tags.FIT_ID')

                     ->select(["fits.ID", "fits.SHIP_ID", "fits.NAME", "fits.STATS", "fits.PRICE", "fits.VIDEO_LINK", "ship_lookup.NAME as SHIP_NAME", DB::raw('(select count(runs.`ID`) from `runs` where runs.`FIT_ID`=fits.`ID`) as `RUNS_COUNT`')])
                     ->distinct("fits.ID");
        }

    }
