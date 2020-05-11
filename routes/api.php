<?php

    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;
    use Illuminate\Support\Facades\Route;

    /*
    |--------------------------------------------------------------------------
    | API Routes
    |--------------------------------------------------------------------------
    |
    | Here is where you can register API routes for your application. These
    | routes are loaded by the RouteServiceProvider within a group which
    | is assigned the "api" middleware group. Enjoy building your API!
    |
    */


    Route::post("fit/callback", function (Request $request) {

        // This is your app secret
        $app_secret = env("FIT_SERVICE_APP_SECRET");

        // This is the thing we will receive
        $expectedAuth = sha1($app_secret);

        // Valudate auth code
        if ($request->get("auth") != $expectedAuth) {
            return response(['error' => 'Invalid auth code provided.'], 403);
        }

        // Get the ID and the data
        $id = $request->get("id");
        $data = $request->get("result");

        Log::info("Fit stats received for $id!");
        $e = DB::table('fits')->where('ID', $id)->update([
            'STATS' => $data,
            'STATUS' => 'done'
        ]);
        if ($e == 0) {
            Log::warning("Could not find fit with ID $id - response ignored.");
        }

        /** @var \App\Http\Controllers\EFT\Tags\TagsController $tags */
        $tags = resolve("\App\Http\Controllers\EFT\Tags\TagsController");
        $tags->applyTags($id, DB::table("fits")->where("ID", $id)->value("RAW_EFT"), $data);
        return [true];
    });
