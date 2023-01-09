<?php


    namespace App\Http\Controllers\Profile;


    use App\Charts\ShipCruiserChart;
	 use App\Http\Controllers\Controller;
	 use App\Http\Controllers\Misc\NotificationController as NotificationControllerAlias;
	 use App\Http\Controllers\ThemeController;
	 use App\Models\Char;
	 use Illuminate\Http\Request;
	 use Illuminate\Support\Facades\Cache;
	 use Illuminate\Support\Facades\DB;
	 use Illuminate\Support\Facades\Log;

	 class SettingController extends Controller {


        /**
         * Handles the settings form
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function index() {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }
            $access = $this->getAllRights(session()->get("login_id"));
            $esi_on = strlen(DB::table("chars")
                               ->where("CHAR_ID", session()->get("login_id"))
                               ->value("REFRESH_TOKEN") ?? "") > 0;

            $rememberCargo = self::getBooleanSetting((int)session()->get("login_id"), 'remember_cargo', true);
//            dd($rememberCargo);
            return view('settings', ['access' => $access, 'esi_on' => $esi_on, 'cargo' => $rememberCargo]);
        }
        /**
        * Save cargo setting for the current user.
         *
         * @param Request $request The request object
         *
         * @return \Illuminate\View\View The view to render
        */

        public function saveCargo(Request $request) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            try {
                $new_cargo = $request->get("save_cargo") == "1";
                self::setBooleanSetting((int)session()->get("login_id"), 'remember_cargo', $new_cargo);
            } catch (\Exception $e) {
                Log::error($e->getMessage() . " " . $e->getFile() . "@" . $e->getLine());

                return view("error", ["error" => "Something went wrong: " . $e->getMessage()]);
            }


            return view("autoredirect", [
                'title' => "Setting saved!",
                'message' => "Abyss Tracker will ".($new_cargo ? "" : "not ")." remember your cargo between runs, for up to ".config("tracker.cargo.saveTime")." minutes.",
                'redirect' => route("settings.index"),
            ]);
        }

        /**
         * Returns a boolean setting stored in DB, cached for up to 20 seconds.
         * @param int    $userId
         * @param string $setting
         * @param bool   $default
         *
         * @return bool|mixed
         */
        public static function getBooleanSetting(int $userId, string $setting, bool $default = false) {
            $dbValue = Cache::remember("aft.setting.bool.{$userId}.{$setting}", now()->addMinute(), function () use ($userId, $setting) {
                return DB::table("preferences")->where("CHAR_ID", $userId)->where("SETTING", strtoupper($setting))->exists() ?
                    DB::table("preferences")->where("CHAR_ID", $userId)->where("SETTING", strtoupper($setting))->first()->VALUE_BOOLEAN :
                    null;
            });

            return $dbValue === null ? $default : $dbValue;
        }

        /**
         * Updates DB
         * @param int    $userId
         * @param string $setting
         * @param bool   $newval
         */
        public static function setBooleanSetting(int $userId, string $setting, bool $newval = false) {
            DB::table("preferences")->updateOrInsert([
                'CHAR_ID' => $userId, 'SETTING' =>strtoupper($setting)
            ], [
                'VALUE_BOOLEAN' => $newval
            ]);
            Cache::forget("aft.setting.bool.{$userId}.{$setting}");
        }
        /**
        * Add a token to the current Char
         *
         * @param Request $request The request containing the token name
         *
         * @return \Illuminate\Http\RedirectResponse The redirect response to the settings page
        */

        public function addToken(Request $request) {
            $request->validate([
                'name' => ['required']
            ]);

            $token = Char::current()->addToken($request->get('name'));
//            dd($token);

            /** @var NotificationControllerAlias $nc */
            $nc = resolve('App\Http\Controllers\Misc\NotificationController');
            $nc->flashInfoLine("New token named saved - Please copy it now, because it won't be visible ever again: <br> <input type='text' class='form-control' readonly='readonly' value='$token' />", "success");

            return redirect(route('settings.index'));

        }

        public function removeToken(int $id) {
            if (Char::current()->tokens()->where('id', $id)->exists()) {
                Char::current()->tokens()->where('id', $id)->delete();
            }
            NotificationControllerAlias::getInstance()->flashToast("The selected token was deleted!");
            return redirect(route('settings.index'));


        }

        public function removeEsi() {

            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            try {
                DB::table("chars")
                  ->where("CHAR_ID", session()->get("login_id"))
                  ->update(["REFRESH_TOKEN" => ""]);
            } catch (\Exception $e) {
                Log::error($e->getMessage() . " " . $e->getFile() . "@" . $e->getLine());
                return view("error", ["error" => "Something went wrong: " . $e->getMessage()]);
            }

            return view("sp_message", [
                'title' => "ESI token revoked",
                'message' => "The ESI token was removed from your account.",
                'redirect' => route("settings.index"),
            ]);

        }

        /**
         * Handles saving settings
         *
         * @param Request $request
         *
         * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
         */
        public function save(Request $request) {
            if (!session()->has("login_id")) {
                return view("error", ["error" => "Please log in to access this page"]);
            }

            $rights = ['LAST_RUNS', 'TOTAL_LOOT', 'TOTAL_RUNS', 'LOOT', 'SHIPS', 'SURVIVAL'];

            try {

                $userId = session()->get("login_id");
                foreach ($rights as $right) {
                    $this->persistRight($userId, $right, intval($request->get($right)) == 1 ? 1 : 0);
                }
            } catch (\Exception $e) {
                Log::error($e->getMessage() . " " . $e->getFile() . "@" . $e->getLine());

                return view("error", ["error" => "Something went wrong: " . $e->getMessage()]);
            }

            return view("autoredirect", [
                'title' => "Settings saved",
                'message' => "Your privacy settings were updated.",
                'redirect' => route("settings.index"),
            ]);
        }


        /**
         * Gets default display levels
         *
         * @param string $panel
         *
         * @return bool
         */
        private function getDefaultVisibility(string $panel) {
            switch ($panel) {
                case 'LAST_RUNS':
                case 'TOTAL_LOOT':
                case 'TOTAL_RUNS':
                case 'ALTS':
                    return true;
                case 'LOOT':
                case 'SHIPS':
                case 'SURVIVAL':
                default:
                    return false;
            }
        }
        /**
        * Gets all rights for the given user ID
         * 
         * @param int $userId The user ID
         * @return array An array containing the rights
        */

        public function getAllRights(int $userId) : array {
            $rights = ["LAST_RUNS", "TOTAL_LOOT", "TOTAL_RUNS", "LOOT", "SHIPS", "SURVIVAL", "ALTS"];
            $ar = [];
            foreach ($rights as $right) {
                $ar[$right] = $this->getRight($userId, $right);
            }

            return $ar;
        }

        /**
         * Persists a DB setting
         *
         * @param int    $userId
         * @param string $panel
         * @param int    $visible
         */
        public function persistRight(int $userId, string $panel, int $visible) : void {
            DB::beginTransaction();
            try {

                if (DB::table("privacy")
                      ->where("CHAR_ID", $userId)
                      ->where("PANEL", $panel)
                      ->exists()) {
                    DB::table("privacy")
                      ->where("CHAR_ID", $userId)
                      ->where("PANEL", $panel)
                      ->update(["DISPLAY" => $visible ? "public" : "private"]);
                } else {
                    DB::table("privacy")
                      ->insert(["CHAR_ID" => $userId, "PANEL" => $panel, "DISPLAY" => $visible ? "public" : "private"]);
                }
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error("SQL error: " . $e->getMessage() . " rolling back transaction.");
                throw $e;
            }
        }

        /**
         * Gets if a panel should be visible
         *
         * @param int    $userId
         * @param string $panel
         *
         * @return bool
         */
        private function getRight(int $userId, string $panel) : bool {
            if (DB::table("privacy")
                  ->where("CHAR_ID", $userId)
                  ->where("PANEL", $panel)
                  ->exists()) {
                return DB::table("privacy")
                         ->where("CHAR_ID", $userId)
                         ->where("PANEL", $panel)
                         ->value("DISPLAY") == 'public';
            } else {
                return $this->getDefaultVisibility($panel);
            }
        }

        /**
         * @return array
         */
        public function getProfileShipsChart(int $id) : array {
            $query_cruiser = Cache::remember("ships.profile.$id", 20, function () use ($id) {
                return DB::select("select count(r.ID) as RUNS, l.Name as NAME, l.ID as SHIP_ID
                    from runs r inner join ship_lookup l on r.SHIP_ID=l.ID
                    where r.CHAR_ID=" . $id . " and r.PUBLIC=1
                    group by r.SHIP_ID, l.NAME, l.ID
                    order by 1 desc
                    limit 15");
            });

            $dataset = [];
            $values = [];
            $i = 7;
            foreach ($query_cruiser as $type) {
                if ($i-- == 0) break;
                $dataset[] = $type->NAME;
                $values[] = $type->RUNS;
            }

            $shipCruiserChart = new ShipCruiserChart();
            $shipCruiserChart->export(true, "Download");
            $shipCruiserChart->displayAxes(false);
            $shipCruiserChart->height(400);
            $shipCruiserChart->theme(ThemeController::getChartTheme());
            $shipCruiserChart->labels($dataset);
            $shipCruiserChart->dataset("Favorite ships", "pie", $values)
                             ->options(["radius" => [30, 120], "roseType" => "radius"]);
            $shipCruiserChart->displayLegend(false);

            return [$query_cruiser, $shipCruiserChart];
        }
    }
