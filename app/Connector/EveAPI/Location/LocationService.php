<?php


    namespace App\Connector\EveAPI\Location;

    use App\Connector\EveAPI\EveAPICore;
    use App\Connector\EveAPI\Universe\ResourceLookupService;
    use Illuminate\Support\Facades\Log;

    class LocationService extends EveAPICore {

        /**
         * Gets the current ship
         *
         * @param int $charId
         *
         * @return \stdClass
         * @throws \Exception
         */
        public function getCurrentLocation(int $charId) : \stdClass {
            try {

                $c = $this->createGet($charId);
                curl_setopt($c, CURLOPT_URL, $this->apiRoot . "characters/$charId/location/");
                $ret = curl_exec($c);
                curl_close($c);

                $val = json_decode($ret);
                /** @var ResourceLookupService $res */
                $res = resolve("App\Connector\EveAPI\Universe\ResourceLookupService");
                $val->solar_system_name = $res->getSystemName($val->solar_system_id);
                if (isset($val->station_id)) $val->station_name = $res->getStationName($val->station_id);
                if (isset($val->structure_id)) $val->structure_name = $res->getStructureName($val->structure_id);

                return $val;
            } catch (\Exception $e) {
                Log::warning("Error during " . $e->getMessage() . " with response " . ($ret ?? "[no response]"));

                return null;
            }
        }


    }
