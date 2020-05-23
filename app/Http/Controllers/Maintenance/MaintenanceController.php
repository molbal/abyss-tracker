<?php


	namespace App\Http\Controllers\Maintenance;


	use App\Http\Controllers\Controller;
    use Illuminate\Support\Facades\Artisan;
    use Illuminate\Support\Facades\DB;

    class MaintenanceController extends Controller {

        function showFlaggedRuns($secret) {
            if ($secret != env("MAINTENANCE_TOKEN")) {
                abort(403, "Invalid maintenance token.");
            }
            $flags = DB::table("run_report")
                       ->where("PROCESSED", false)
                       ->orderBy("CREATED_AT", "DESC")
                       ->get();

            return view("sp_message", ["title" => "Flagged runs", "message" => print_r($flags, true)]);
        }

        function deleteFlaggedRun(int $id, string $secret) {
            if ($secret != env("MAINTENANCE_TOKEN")) {
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
            if ($secret != env("MAINTENANCE_TOKEN")) {
                abort(403, "Invalid maintenance token.");
            }
            echo "DB maintenance starts <br>";
            echo Artisan::call('migrate', ['--force' => true]);
            echo "DB maintenance Over";
        }

        function debugLogin($login_id, $secret) {
            if ($secret != env("MAINTENANCE_TOKEN")) {
                abort(403, "Invalid maintenance token.");
            }
            session()->put("login_id", $login_id);
            session()->put("login_name", "TEST LOGIN $login_id");

            return redirect(\route("home_mine"));
        }

        function recalculateSingleFit($id, $secret) {
            if ($secret != env("MAINTENANCE_TOKEN")) {
                abort(403, "Invalid maintenance token.");
            }

            /** @var \App\Http\Controllers\FitsController $fits */
            $fits = resolve('App\Http\Controllers\FitsController');
            $fit = DB::table("fits")->where("ID", $id)->select(["RAW_EFT", "SHIP_ID"])->first();
            $fits->submitSvcFitService($fits->getFitHelper()->pyfaBugWorkaround($fit->RAW_EFT, $fit->SHIP_ID), $id);

            return redirect(\route("fit_single", ["id" => $id]));
        }

        function recalculateQueuedFits($secret) {
            if ($secret != env("MAINTENANCE_TOKEN")) {
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

            if ($secret != env("MAINTENANCE_TOKEN")) {
                abort(403, "Invalid maintenance token.");
            }
        }
	}
