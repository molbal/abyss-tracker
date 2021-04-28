<?php


	namespace App\Http\Controllers\Maintenance;


	use App\Http\Controllers\Auth\AuthController;
    use App\Http\Controllers\Controller;
    use App\Http\Controllers\DS\MedianController;
    use App\Http\Controllers\EFT\FitParser;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class MaintenanceController extends Controller {

        public function medianTests() {
//            /** @var MedianController $cont */
//            $cont = resolve('App\Http\Controllers\DS\MedianController');

            $a = collect([]);
            for ($i=0;$i<=6;$i++) {
                $a->add(["Tier $i" => [
                    'cruiser' => number_format(MedianController::getTierMedian($i, true), 0, ","," ")." ISK",
                    'frigate' => number_format(MedianController::getTierMedian($i, false), 0, ","," ")." ISK",
                ]]);
            }

            return $a;
        }

        function convertOldFits($secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }

            $items = DB::select('select ID, RAW_EFT from fits where (select count(*) from parsed_fit_items where parsed_fit_items.FIT_ID=fits.ID)=0;');

            /** @var FitParser $fp */
            $fp = resolve('App\Http\Controllers\EFT\FitParser');
            foreach ($items as $item) {
                set_time_limit(1800);
                try {

                $eft = $fit = $fp->getFitTypes($item->RAW_EFT);
                $eft->persistLines($item->ID);

                    Log::info("Persisted fit: ".$item->ID);
                }
                catch (\Exception $e) {
                    Log::error($e);
                }
            }
            return ["Ok"];
        }


        function showFlaggedRuns($secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }
            $flags = DB::table("run_report")
                       ->where("PROCESSED", false)
                       ->orderBy("CREATED_AT", "DESC")
                       ->get();

            return view("sp_message", ["title" => "Flagged runs", "message" => print_r($flags, true)]);
        }

        function deleteFlaggedRun(int $id, string $secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }

            DB::table("run_report")
              ->where("RUN_ID", $id)
              ->update(["PROCESSED" => true]);
            DB::table("detailed_loot")
              ->where("RUN_ID", $id)
              ->delete();
            DB::table("lost_items")
              ->where("RUN_ID", $id)
              ->delete();
            DB::table("runs")
              ->where("ID", $id)
              ->delete();


            return view("sp_message", ["title" => "Flagged runs", "message" => "Run #$id destroyed"]);
        }

        function runMigrations($secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }
            echo "DB maintenance starts <br>";
            echo Artisan::call('migrate', ['--force' => true]);
            echo "DB maintenance Over";
        }

        function debugLogin($login_id, $secret) {
            if ($secret != config('tracker.maintenance-token') && config('app.debug')) {
                abort(403, "Invalid maintenance token.");
            }
            auth()->login(AuthController::charIdToFrameworkUser($login_id));
            session()->forget(["login_id", "login_name"]);
            session()->put("login_id", $login_id);
            session()->put("login_name", DB::table('chars')->where('CHAR_ID', $login_id)->first('NAME')->NAME);

            return redirect(\route("home_mine"));
        }

        function recalculateSingleFit($id, $secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }

            /** @var \App\Http\Controllers\FitsController $fits */
            $fits = resolve('App\Http\Controllers\FitsController');
            $fit = DB::table("fits")->where("ID", $id)->select(["RAW_EFT", "SHIP_ID"])->first();
            $fits->submitSvcFitService($fits->getFitHelper()->pyfaBugWorkaround($fit->RAW_EFT, $fit->SHIP_ID), $id);

            return redirect(\route("fit_single", ["id" => $id]));
        }

        public function getRoutes($secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token: " .  config('tracker.maintenance-token'));
            }

            $routes = [];
            foreach (\Route::getRoutes()->getIterator() as $route){
                $routes[] = $route->uri;
            }
            dd(compact('routes'));
//                return view('sp_message', [compact('routes'));


        }

        public function resetAndCache($secret) {
//            if ($secret != config('tracker.maintenance-token')) {
//                abort(403, "Invalid maintenance token.");
//            }

            try {
            echo Artisan::call('config:clear');
            echo Artisan::call('route:clear');

//            echo Artisan::call('optimize');

//            echo Artisan::call('config:cache');
            echo Artisan::call('route:cache');
            }
            catch (\Exception $e) {
                dd($e);
            }

        }

        function recalculateQueuedFits($secret) {
            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }

            $IDs = DB::table("fits")->where("STATUS", 'queued')->get();

            echo "Starting <br><pre>";
            foreach ($IDs as $id) {
                $id = $id->ID;
                /** @var \App\Http\Controllers\FitsController $fits */
                $fits = resolve('App\Http\Controllers\FitsController');
                $fit = DB::table("fits")->where("ID", $id)->select(["RAW_EFT", "SHIP_ID"])->first();
                $fits->submitSvcFitService($fits->getFitHelper()->pyfaBugWorkaround($fit->RAW_EFT, $fit->SHIP_ID), $id);

                echo "Resubmitted $id \n";
            }
            echo "</pre>";
        }

        function afterReleaseActions($secret) {

            if ($secret != config('tracker.maintenance-token')) {
                abort(403, "Invalid maintenance token.");
            }
        }
	}
