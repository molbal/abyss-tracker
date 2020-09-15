<?php


    namespace App\Http\Controllers;


    use App\Connector\EveAPI\Location\LocationService;
    use App\Exceptions\ESIAuthException;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class StopwatchController extends Controller {

        /**
         * Sets a stopwatch instance
         *
         * @param int $charId
         * @return array
         * @throws \Exception
         */
        public function addChecks(int $charId) {

            DB::beginTransaction();
            if (DB::table("stopwatch")->where("CHAR_ID", $charId)->exists()) {
                DB::table("stopwatch")->where("CHAR_ID", $charId)->delete();
            }

            DB::table("stopwatch")->insert([
                "CHAR_ID" => $charId,
                "EXPIRE" => date("Y-m-d H:i:s", strtotime("now +40 minutes")),
                "IN_ABYSS" => false
            ]);
            DB::commit();

            return [true];
        }

        public function getAbyssState(int $charId) {


            if (DB::table("chars")->where("CHAR_ID", $charId)->value("REFRESH_TOKEN") == "") {
                return [
                    'status' => 'error',
                    'infodiv' => 'error',
                    'seconds' => 0
                ];
            }

            $state = [
                'status' => 'error',
                'seconds' => 0
            ];
            if (DB::table("stopwatch")->where("CHAR_ID", $charId)->exists()) {
                $var = DB::table("stopwatch")->where("CHAR_ID", $charId)->get()->get(0);
                if ($var->IN_ABYSS) {
                    $state = [
                        'status' => "RUNNING",
                        'infodiv' => "running",
                        'seconds' => (strtotime(date("Y-m-d H:i:s")) - strtotime($var->ENTERED_ABYSS))
                    ];
                }
                elseif ($var->EXITED_ABYSS) {
                    $state = [
                        'status' => "<span class=\"text-success\">FINISHED</span>",
                        'infodiv' => "finished",
                        'seconds' => (strtotime($var->EXITED_ABYSS) - strtotime($var->ENTERED_ABYSS))
                    ];
                }
                else {
                    $state = [
                        'status' => '<span class="text-warning">WAITING TO ENTER THE ABYSS</span>',
                        'infodiv' => "starting",
                        'seconds' => 0
                    ];
                }
            }
            else {
                $state = [
                    'status' => 'READY TO START STOPWATCH',
                    'seconds' => 0
                ];
            }

            return $state;
        }

        public function updateEsi() {
            $chars = DB::table("stopwatch")->select("CHAR_ID")->get();
            foreach ($chars as $char) {
                try {
                    $this->getAbyssFromESI($char->CHAR_ID);
                    //Log::debug(sprintf("Updated location from ESI for %d", $char->CHAR_ID));
                }
                catch (\Exception $e) {
                    Log::channel("stopwatch")->warning(sprintf("Could not check ESI for char %d: %s %s@%d",$char->CHAR_ID, $e->getMessage(), $e->getFile(), $e->getLine())." - removing stopwatch");
                    DB::table("stopwatch")->where("CHAR_ID", $char->CHAR_ID)->delete();
                }
            }
            unset($chars);
        }

        /**
         * Updates a characters status from the ESI
         * @param int $charId
         * @throws \Exception
         */
        public function getAbyssFromESI(int $charId) {
            /** @var LocationService $locationService */
            $locationService = resolve('App\Connector\EveAPI\Location\LocationService');

            if (!DB::table("stopwatch")->where("CHAR_ID", $charId)->exists()) {
                throw new \Exception(sprintf("Stopwatch doesnt exist with charid %d!", $charId));
            }

            if (DB::table("chars")->where("CHAR_ID", $charId)->value("REFRESH_TOKEN") == "") {
                throw new \Exception(sprintf("Stopwatch is turned off for  charid %d!", $charId));
            }

            $var = DB::table("stopwatch")->where("CHAR_ID", $charId)->first();
            try {
                $loc = Cache::remember(sprintf("location.cache.%d", $charId), now()->addSeconds(7), function() use ($locationService, $charId){
                   return $locationService->getCurrentLocation($charId);
                });
            }
            catch (ESIAuthException $e) {
                DB::table("chars")->where("CHAR_ID", $charId)->update(["REFRESH_TOKEN" => ""]);
                throw new ESIAuthException("Auth exception, removed refresh token. Please auth again.");
            }

            unset($locationService);
            $preAbyss = $var->IN_ABYSS ? true : false;

            if (!$loc)  {
                throw new \Exception("Could check not location for user $charId");
            }
            $nowAbyss = $this->isAbyssSystem($loc->solar_system_name);
            //Log::info(sprintf("Comparsion for %s pre: %s now: %s", $charId, $preAbyss ? "in" : "out", $nowAbyss ? "in" : "out"));

            if ($preAbyss != $nowAbyss) {
                if ($preAbyss) {
                    // Old tick: IN ABYSS, new tick: OUTSIDE ABYSS
                    DB::table("stopwatch")->where("CHAR_ID", $charId)->update([
                        'EXITED_ABYSS' => date("Y-m-d H:i:s"),
                        "IN_ABYSS" => false
                    ]);

                }
                else {
                    // ld tick: OUTSIDE ABYSS, new tick: IN ABYSS
                    DB::table("stopwatch")->where("CHAR_ID", $charId)->update([
                       'ENTERED_ABYSS' => date("Y-m-d H:i:s"),
                       "IN_ABYSS" => true
                    ]);
                }
            }

            if (time() > strtotime($var->EXPIRE)) {
                //Log::info("Expired! Removing $charId from stopwatch.");
                DB::table("stopwatch")->where("CHAR_ID", $charId)->delete();
            }
        }

        /**
         * Returns whether a system is an Abyss system
         * @param string $systemName
         * @return boolean
         */
        private function isAbyssSystem(string $systemName):bool {
            $regex = '/^AD[0-9]{3}$/';
            $pregMatch = preg_match($regex, $systemName) == 1;
            //Log::debug("System $systemName is ".($pregMatch ? "an" : "not an")." Abyss system.");
            return $pregMatch;
        }



    }
