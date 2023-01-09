<?php


	namespace App\Http\Controllers\EFT;

    use App\Http\Controllers\Controller;
    use App\Http\Controllers\PVP\PvpStats;
    use App\Pvp\PvpShipStat;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\ModelNotFoundException;
    use Illuminate\Http\Request;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class FitCallbackController extends Controller {
        /**
        * Handles Fit callback with the given request
         * 
         * @param Request $request The request object
         * @return array The response array
        */

        function handleFitCallback(Request $request) {
//            Log::debug('Fit callback with '.print_r($request->all(), 1));

            // This is your app secret
            $app_secret = config('fits.auth.secret');

            // This is the thing we will receive
            $expectedAuth = sha1($app_secret);

            // Valudate auth code
            if ($request->get("auth") != $expectedAuth) {
                return response(['error' => 'Invalid auth code provided.'], 403);
            }

            // Get the ID and the data
            $idRaw = $request->get("id");
            $data = $request->get("result");

            // Separate the prefix from the ID
            [$prefix, $id] = explode(':', $idRaw, 2);

            $id = intval($id);

            switch ($prefix) {
                case config('fits.prefix.default'):

                    try {
                        $this->handleDefaultCallback($id, $data);
                    }
                    catch (\Exception $e) {
                        return response(['error' => $e->getMessage(), 'error_type' => get_class($e)], 404);
                    }
                    break;
                case config('fits.prefix.pvp'):

                    try {
                        $this->handlePvpCallback($id, $data);
                    }
                    catch (\Exception $e) {
                        return response(['error' => $e->getMessage(), 'error_type' => get_class($e)], 404);
                    }
                    break;
            }
            return [true];
        }

        /**
         * @param string $id
         * @param mixed  $data
         */
        private function handleDefaultCallback(int $id, mixed $data) : void {
            if (DB::table("fits")
                  ->where('ID', $id)
                  ->doesntExist()) {
                throw new ModelNotFoundException("No such fit with ID $id");
            }

            Log::info("Fit stats received for $id!");
            DB::table('fits')
              ->where('ID', $id)
              ->update(['STATS' => $data, 'STATUS' => 'done']);

            /** @var \App\Http\Controllers\EFT\Tags\TagsController $tags */
            $tags = resolve("\App\Http\Controllers\EFT\Tags\TagsController");
            $tags->applyTags($id, DB::table("fits")
                                    ->where("ID", $id)
                                    ->value("RAW_EFT"), $data);
            FitHistoryController::addEntry($id, "Fit stats calculation finished.");
        }
        /**
        * Handle the callback from the PVP API
         * 
         * @param int $id The ID of the killmail
         * @param mixed $data The data received from the PVP API
         * 
         * @return void
        */


        private function handlePvpCallback(int $id, mixed $data) {

            if (PvpShipStat::whereKillmailId($id)->exists()) {
                $shipStats = PvpShipStat::whereKillmailId($id)->firstOrFail();
            }
            else {
                $shipStats = new PvpShipStat();
                $shipStats->fill([
                    'eft' => null,
                    'killmail_id' => $id
                ]);
            }

            $shipStats->fill([
                'error_text' => null,
                'stats' => $data,
            ]);

            $shipStats->save();
            Log::channel('pvp')->debug('Stats info received for killmail #'.$id);
        }

    }
