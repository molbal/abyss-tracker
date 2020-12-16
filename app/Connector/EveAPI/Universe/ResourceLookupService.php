<?php


    namespace App\Connector\EveAPI\Universe;


    use App\Connector\EveAPI\EveAPICore;
    use Illuminate\Support\Facades\Cache;
    use Illuminate\Support\Facades\DB;
    use Illuminate\Support\Facades\Log;

    class ResourceLookupService extends EveAPICore {

        /**
         * Gets the character name in the following order:
         *  1. Checks the registered characters table (Among the users of co-pilot)
         *  2. Checks the "Forever cache" table for known entries
         *  3. Calls the ESI for name lookup (And caches the result afterwards)
         *
         * @param int $charId
         * @return bool|mixed|string
         * @throws \Exception
         */
        public function getCharacterName(int $charId) {
            if (DB::table("characters")->where("ID", "=", $charId)->exists()) {
                return DB::table("characters")->where("ID", "=", $charId)->get()->get(0)->NAME;
            }

            if ($this->forevercacheHas($charId)) {
                return $this->forevercacheGet($charId);
            }

            $ch = $this->createPost();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/names/");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$charId]));

            $ret = curl_exec($ch);
            curl_close($ch);

            $ret = json_decode($ret);
            if (isset($ret->error)) {
                throw new \Exception($ret->error);
            } else {
                $ret = $ret[0]->name;
            }
            $this->forevercachePut($charId, $ret);
            return $ret;
        }

        /**
         * Gets the character name in the following order:
         *  1. Checks the registered characters table (Among the users of co-pilot)
         *  2. Checks the "Forever cache" table for known entries
         *  3. Calls the ESI for name lookup (And caches the result afterwards)
         *
         * @param int $charName
         * @return bool|mixed|string
         * @throws \Exception
         */
        public function getCharacterId(string $charName): int {
            if (DB::table("characters")->where("NAME", "=", $charName)->exists()) {
                return DB::table("characters")->where("NAME", "=", $charName)->get()->get(0)->ID;
            }

            $cacheKey = "CharNameLookup-" . md5($charName);
            if (\Illuminate\Support\Facades\Cache::has($cacheKey)) {
                return \Illuminate\Support\Facades\Cache::get($cacheKey);
            }


            $ch = $this->createPost();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/ids/");
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode([$charName]));

            $ret = curl_exec($ch);
            curl_close($ch);

            $ret = json_decode($ret);
            if (isset($ret->error)) {
                throw new \Exception($ret->error);
            } else {
                $ret = $ret->characters[0]->id;
            }

            // Cache name for 3 days
            \Illuminate\Support\Facades\Cache::put($cacheKey, $ret, 60 * 24 * 3);
            return $ret;
        }

        /**
         * Gets a station name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $stationId
         * @return mixed|string
         * @throws \Exception
         */
        public function getStationName(int $stationId) {
            if ($this->forevercacheHas($stationId)) {
                return $this->forevercacheGet($stationId);
            }

            $stationName = $this->simpleGet(null, "universe/stations/{$stationId}/")->name ?? "[unknown station $stationId]";


            $this->forevercachePut($stationId, $stationName);
            return $stationName;

        }


        /**
         * Gets a solar system name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $systemId
         * @return mixed|string
         * @throws \Exception
         */
        public function getSystemName(int $systemId) {
            if ($this->forevercacheHas($systemId)) {
                return $this->forevercacheGet($systemId);
            }

            $ch = $this->createGet();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/systems/{$systemId}/");
            $ret = curl_exec($ch);
            curl_close($ch);

            /** @var string $stationName */
            $stationName = json_decode($ret)->name ;

            $this->forevercachePut($systemId, $stationName);
            return $stationName;

        }


        /**
         * Gets a structure name. Makes a call to ESI unless the result is already cached.
         *
         * @param int $structureId
         * @return mixed|string
         * @throws \Exception
         */
        public function getStructureName(int $structureId) {

            $ch = $this->createGet();
            curl_setopt($ch, CURLOPT_URL, $this->apiRoot . "universe/structures/{$structureId}/");
            $ret = curl_exec($ch);
            curl_close($ch);

            /** @var string $stationName */
            try {
                $stationName = json_decode($ret)->name;
            }
            catch (\Exception $e) {
                $this->logError($this->apiRoot . "universe/structures/{$structureId}/", $e->getMessage());
                $stationName = "[Unknown structure $structureId]";
            }
            return $stationName;
        }

        /**
         * Gets the ID of a station, from its name
         *
         * @param string $stationFullName
         * @return mixed
         * @throws \Exception
         */
        public function getStationId(string $stationFullName): int {
            $response = $this->simplePost(null, "universe/ids", json_encode([$stationFullName]));

            if (isset($response->stations)) {
                $stationId = $response->stations[0]->id;
            } else {
                $this->logError($this->apiRoot . "universe/ids", "Cannot find the Eve ID number for station [$stationFullName].");
                throw new \InvalidArgumentException("Cannot find the Eve ID number for this station.");
            }
            return $stationId;
        }

        /**
         * Gets the ID of a structure, from its name
         *
         * @param string $fullName
         * @return mixed
         * @throws \Exception
         */
        public function getStructureId(string $fullName): int {
            $response = $this->simplePost(null, "universe/ids", json_encode([$fullName]));

            if (isset($response->structure)) {
                $stationId = $response->structure[0]->id;
            } else {
                $this->logError($this->apiRoot . "universe/ids", "Cannot find the Eve ID number for structure [$fullName].");
                throw new \InvalidArgumentException("Cannot find the Eve ID number for this structure.");
            }
            return $stationId;
        }

        /**
         * Gets the ID of a solar system, from its name
         *
         * @param string $fullName
         * @return mixed
         * @throws \Exception
         */
        public function getSolarSystemId(string $fullName): int {
            $response = $this->simplePost(null, "universe/ids", json_encode([$fullName]));

            if (isset($response->systems[0]->id)) {
                $systemId = $response->systems[0]->id;
            } else {
                $this->logError($this->apiRoot . "universe/ids", "Cannot find the Eve ID number for solar system [$fullName].");
                throw new \InvalidArgumentException("Cannot find the Eve ID number for this ID: $fullName.");
            }
            return $systemId;
        }

        /**
         * Gets the item ID of an inventory name
         * @param string $fullName
         *
         * @return mixed
         * @throws \Exception
         */
        public function itemNameToId(string $fullName) {
            $fullName = trim($fullName);

            // Try from item prices table
            if(DB::table("item_prices")->where("NAME", $fullName)->exists()) {
                return DB::table("item_prices")->where("NAME", $fullName)->value("ITEM_ID");
            }

            // Get old dumps
            $tables = Cache::remember("aft.dump-tablelists", now()->addHour(), function () {
               return DB::table("previous_dumps_tables")->orderBy("ORDER_ASC", "ASC")->get();
            });

            // Try old dumps
            foreach ($tables as $table) {
                if (DB::table($table->TABLE_NAME)->where("typeName",'=', $fullName)->exists()) {
                    return DB::table($table->TABLE_NAME)->where("typeName",'=', $fullName)->value("typeID");
                }
            }

            // Try ESI
            $response = $this->simplePost(null, "universe/ids", json_encode([$fullName]));

            if (isset($response->inventory_types[0]->id)) {
                $invType = $response->inventory_types[0]->id;
            } else {
                $this->logError($this->apiRoot . "universe/ids", "Cannot find the Eve ID number for item [$fullName].");
//                Log::warning("Cannot find the Eve ID number for this name: [$fullName]"." response: <".print_r($response, 1).">");
                throw new \InvalidArgumentException("Cannot find the Eve ID number for this name: $fullName");
            }

            return $invType;
        }


        /**
         * General name lookup. Caches and works for ItemIDs and solar systems too
         *
         * @param int $id
         * @return string
         * @throws \Exception
         */
        public function generalNameLookup(int $id): string {
            return Cache::remember("aft.general-name-lookup".$id, now()->addMinutes(30), function() use ($id) {
                if ($this->forevercacheHas($id)) {
                    return $this->forevercacheGet($id);
                }
                $resp = $this->simplePost(null, "universe/names", json_encode([$id]));

                $name = $resp[0]->name;
                if (isset($name)) {
                    $this->forevercachePut($id, $name);
                    return $name;
                }
                $this->logError($this->apiRoot . "universe/names", "Cannot find the name for ID [$id].");
                throw new \InvalidArgumentException("No item ID with name $id found in ESI");
            });
        }

        /**
         * General name lookup. Caches and works for ItemIDs and solar systems too
         *
         * @param int $id
         * @return array
         * @throws \Exception
         */
        public function getItemInformation(int $id): array {
            return Cache::remember("ast.getItemInformation.$id", now()->addMinute(), function() use ($id) {
                $resp = $this->simpleGet(null, sprintf("universe/types/%d", $id), true);
                if (!$resp) {
                    $this->logError(sprintf("%suniverse/types/%d", $this->apiRoot,$id), "getItemInformation failed for [$id].");
                }
                return $resp;
            });
        }

        /**
         * Returns group IDs for categories
         * @param int $categoryId
         *
         * @return array
         * @throws \Exception
         */
        public function getCategoryGroups(int $categoryId): array {
            return Cache::remember("ast.getCategoryGroups.$categoryId", now()->addMinute(), function() use ($categoryId) {
                $resp = $this->simpleGet(null, sprintf("universe/categories/%d", $categoryId), true);
                if (!$resp) {
                    $this->logError(sprintf("%suniverse/categories/%d", $this->apiRoot,$categoryId), "getCategoryGroups failed for [$categoryId].");
                }
                return $resp["groups"] ?? null;
            });
        }


        /**
         * Returns group IDs for categories
         *
         * @param int $groupId
         *
         * @return array
         * @throws \Exception
         */
        public function getGroupInfo(int $groupId): array {
            return Cache::remember("ast.getGroupInfo.$groupId", now()->addMinute(), function () use ($groupId) {
                $resp = $this->simpleGet(null, sprintf("universe/groups/%d", $groupId), true);
                if (!$resp) {
                    $this->logError(sprintf("%suniverse/groups/%d", $this->apiRoot,$groupId), "getGroupInfo failed for [$groupId].");
                }
                return $resp;
            });
        }

		/**
		 * Gets the security status
		 * @param int $charId
		 *
		 * @return float
		 * @throws \Exception
		 */
        public function getSecurityStatus(int $charId): float {
            if (Cache::has("sec-status-$charId")) {
                return Cache::get("sec-status-$charId");
            }

            $ret = $this->simpleGet($charId, "characters/$charId/");
            if (isset($ret->security_status)) {
                Cache::put("sec-status-$charId", $ret->security_status, 30);
                return $ret->security_status;
            }
            else {
                throw new \Exception("Could not get sec status for $charId -> " .print_r($ret, 1) );
            }
        }
    }
