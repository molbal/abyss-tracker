<?php

namespace App\Http\Controllers\VideoTutorials;

use App\Http\Controllers\Controller;
use App\VideoTutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class VideoTutorialsController extends Controller
{
    public function index() {
        $tutorials = Cache::remember("tutorials-list", now()->addMinute(), function () {
          return VideoTutorial::with("content_creator")->get();
        });

        return view("tutorials", [
            'tutorials' => $tutorials
        ]);
    }

    public function get(int $id, string $slug) {
        return ["id" =>$id];
    }
    public function creatorIndex(int $id, string $slug) {
        return ["id" =>$id];
    }
}
