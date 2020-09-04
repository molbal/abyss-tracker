<?php

    namespace App\Http\Controllers\VideoTutorials;

    use App\Http\Controllers\Controller;
    use App\VideoTutorial;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;

    class VideoTutorialsController extends Controller {
        public function index() {
            $tutorials = Cache::remember("tutorials-lisst", now()->addSecond(), function () {
                $tutorials = VideoTutorial::with("content_creator")
                                          ->orderBy("created_at", "desc")
                                          ->get();

                foreach ($tutorials as $tutorial) {
                    $tutorial->positive = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "positive")->count();
                    $tutorial->negative = DB::table("tutorial_votes")->where("video_id", $tutorial->id)->where("opinion", "negative")->count();
                }

                return $tutorials;


            });


            return view("tutorials", ['tutorials' => $tutorials]);
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
            return view("tutorial", ["tutorial" => $tutorial]);
        }

        public function creatorIndex(int $id, string $slug) {
            return ["id" => $id];
        }
    }
