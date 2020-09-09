<?php

    namespace App\Http\Controllers\VideoTutorials;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\FitSearchController;
    use App\Tracker\YoutubeEmbed;
    use App\VideoTutorial;
    use Illuminate\Http\Request;
    use Illuminate\Support\Arr;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class VideoTutorialsController extends Controller {


        /** @var FitSearchController */
        private $fitSearchController;

        /**
         * InfopageController constructor.
         *
         * @param FitSearchController $fitSearchController
         */
        public function __construct(FitSearchController $fitSearchController) {
            $this->fitSearchController = $fitSearchController;
        }



        public function index() {
            $tutorials = Cache::remember("tutorials-lisst", now()->addSecond(), function () {
                $tutorials = VideoTutorial::with("content_creator")
                                          ->orderBy("created_at", "desc")
                                          ->get();

                foreach ($tutorials as $tutorial) {
                    $tutorial->positive = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "approves")->count();
                    $tutorial->negative = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "disapproves")->count();
                }

                return $tutorials;


            });


            return view("tutorials", ['tutorials' => $tutorials]);
        }

        public function vote(int $id, string $vote) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to vote"]);
            }

            if (!VideoTutorial::with("content_creator")->where("id", $id)->exists()) {
                return view("error", ["message" => "No such tutorial"]);
            }

            DB::table("tutorial_votes")->updateOrInsert([
                "video_id" => $id,
                "char_id" => session()->get("login_id")
            ], ['opinion' => $vote == "plus" ? "approves" : "disapproves"]);

            return redirect(route("tutorials.get", ["id" => $id, "slug" => "-"]));
        }

        public function get(int $id, string $slug) {
            try {
                if (!VideoTutorial::with("content_creator")->where("id", $id)->exists()) {
                    return view("error", ["message" => "No such tutorial"]);
                }
                $tutorial = VideoTutorial::with("content_creator")->where("id", $id)->first();

            }
            catch (\Exception $e) {
                return view("error", ["message" => "Error displaying tutorial: ".$e->getMessage()]);
            }

            $embed = new YoutubeEmbed($tutorial->youtube_id);
            $embed->setBookmarks($tutorial->video_bookmarks);

            $description = (new \Parsedown())->parse($tutorial->description);

            $fit_ids = DB::table("video_tutorial_fits")->where("video_tutorial_id", $id)->select(["fit_id"])->get();
            $fits = $this->fitSearchController->getStartingQuery()->whereIn('fits.ID', Arr::pluck($fit_ids, 'fit_id'))->get();

            foreach ($fits as $i => $result) {
                $fits[$i]->TAGS = $this->fitSearchController->getFitTags($result->ID);
            }
            $tutorial->positive = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "approves")->count();
            $tutorial->negative = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "disapproves")->count();
            return view("tutorial", ["tutorial" => $tutorial, 'embed' => $embed, 'description' => $description, 'fits' => $fits]);
        }

        public function creatorIndex(int $id, string $slug) {

            $tutorials = Cache::remember("tutorials-lisst", now()->addSecond(), function () use ($id) {
                $tutorials = VideoTutorial::with("content_creator")
                                          ->where("content_creator_id", '=', $id)
                                          ->orderBy("created_at", "desc")
                                          ->get();

                foreach ($tutorials as $tutorial) {
                    $tutorial->positive = DB::table("tutorial_votes")
                                            ->where("video_id", $tutorial->id)
                                            ->where("opinion", "approves")
                                            ->count();
                    $tutorial->negative = DB::table("tutorial_votes")
                                            ->where("video_id", $tutorial->id)
                                            ->where("opinion", "disapproves")
                                            ->count();
                }

                return $tutorials;


            });


            if ($tutorials->count() > 0)
                return view("tutorials_creator", ['tutorials' => $tutorials, 'content_creator' => $tutorials->first()->content_creator]);
            else
                return view("error", ["message" => "No such content creaor"]);
        }
    }
