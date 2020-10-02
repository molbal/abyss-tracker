<?php


	namespace App\Http\Controllers\EFT;

    use App\Http\Controllers\Controller;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitCallbackController extends Controller {

        function handleFitCallback(Request $request) {

            // This is your app secret
            $app_secret = config('fits.auth.secret');

            // This is the thing we will receive
            $expectedAuth = sha1($app_secret);

            // Valudate auth code
            if ($request->get("auth") != $expectedAuth) {
                return response(['error' => 'Invalid auth code provided.'], 403);
            }

            // Get the ID and the data
            $id = $request->get("id");
            $data = $request->get("result");

            if (DB::table("fits")->where('ID', $id)->doesntExist()) {
                return response(['error' => sprintf("No such fit with ID %d", $id)], 404);
            }

            Log::info("Fit stats received for $id!");
            DB::table('fits')->where('ID', $id)->update([
                'STATS' => $data,
                'STATUS' => 'done'
            ]);

            /** @var \App\Http\Controllers\EFT\Tags\TagsController $tags */
            $tags = resolve("\App\Http\Controllers\EFT\Tags\TagsController");
            $tags->applyTags($id, DB::table("fits")->where("ID", $id)->value("RAW_EFT"), $data);
            return [true];
        }
	}
